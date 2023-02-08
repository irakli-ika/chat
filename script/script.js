let qty = 0;
function getMessages(){
    const request = new XMLHttpRequest();
    request.addEventListener("readystatechange", () => {
        if (request.readyState === 4 && request.status === 200) {
            loader.style.display = 'none';
        }
      });
    request.open("GET", `api/get_messages.php?conversation_id=${conversation_id}&user_id=${user_id}`);
    
    request.onload = function(){
      const results = JSON.parse(request.responseText);
      const html = results.map(function(message){
          if (message.sender_id != user_id){
              return `<div class="receive-message">
                        <div>
                            <div class="message-author">
                                <a href="#">${message.name} ${message.last_name}</a>
                            </div>
                            <p>${message.message}</p>
                        </div>
                    </div>`
            } else {
                return `<div class="sent-message">
                            <div>
                                <div class="message-author">
                                    <a href="#">${message.name} ${message.last_name}</a>
                                </div>
                                <p>${message.message}</p>
                                <i class="fa-solid fa-ellipsis-vertical deleteMessage" onclick="openDelModal(event)" data-message-id=${message[0]}></i>
                                <div class="deleteModal">
                                    <button onclick="deleteMessage(${message[0]})">წაშლა</button>
                                </div>
                            </div>
                        </div>`
            }
        }).join('');
        const messages = document.querySelector('.message-body > div');

        console.log(results.length + "up");

        console.log(document.getElementById(`${conversation_id}`).childElementCount);

        if (document.getElementById(`${conversation_id}`).childElementCount < results.length) {
            messages.innerHTML = html;
            document.querySelector('.message-body').scrollTop = messages.scrollHeight;
        }
        // console.log(results.length + "up");

        // console.log(document.getElementById(`${conversation_id}`).childElementCount);
        // qty = results.length
    }
    request.send();
}
// send message
document.querySelector('form').addEventListener('submit', (e)=> {
    e.preventDefault();
    const message_inner = document.getElementById('message-inner');
    const message = message_inner.message.value;
    const data = new FormData();
    data.append('message', message);
    data.append('sender_id', user_id);
    data.append('conversation_id', conversation_id);
    
    const request = new XMLHttpRequest();
    request.open('POST', 'api/send_messages.php');
    
    request.onload = function(){
        message_inner.message.value = '';
        message_inner.message.focus();
        getMessages();
    }
    if (message.length > 0) {
        request.send(data);
    }
});

function getUserlist(status) {
    const request = new XMLHttpRequest();
    // request.addEventListener("readystatechange", () => {
    //     if (request.readyState === 4 && request.status === 200) {
    //         loader.style.display = 'none';
    //     }
    //   });
    request.open("GET", `api/get_user_list.php?user_id=${user_id}`);
  
    request.onload = function(){
      const results = JSON.parse(request.responseText);
      const html = results.map(function(message){
        if (status == 'all') {
            return `<button class="member-list" onclick="openMessage(this)" data-id="${message.conversation_id ?? message.id}" data-isgroup="${message.is_group ?? 'false'}">
                        <div class="user-content">
                            <div class="avatar-holder">
                                <img src="" alt="">
                            </div>
                            <div class="user-details">
                                <h1>${message.is_group ? message.name : message.name + " " + message.last_name}</h1>
                                <!-- <p>hello I'm Irakli Qiria how are you</p> -->
                            </div>
                        </div>
                    </button>`
        } else if(status == 'dialog') {
            if (!message.is_group) {
                return `<button class="member-list" onclick="openMessage(this)" data-id="${message.conversation_id}" data-isgroup="'false'">
                <div class="user-content">
                                <div class="avatar-holder">
                                    <img src="" alt="">
                                </div>
                                <div class="user-details">
                                <h1>${message.name} ${message.last_name}</h1>
                                <!-- <p>hello I'm Irakli Qiria how are you</p> -->
                                </div>
                                </div>
                                </button>`
            }
        } else {
            if (message.is_group) {
                return `<button class="member-list" onclick="openMessage(this)" data-id="${message.id}" data-isgroup="${message.is_group}">
                                <div class="user-content">
                                    <div class="avatar-holder">
                                        <img src="" alt="">
                                    </div>
                                    <div class="user-details">
                                        <h1>${message.name}</h1>
                                        <!-- <p>hello I'm Irakli Qiria how are you</p> -->
                                    </div>
                                </div>
                            </button>`
            }
        }
        }).join('');
        
        // changing content if has change
        // if (qty < results.length) {
        //     const messages = document.querySelector('.message-body > div');
        //     messages.innerHTML = html;
        //     document.querySelector('.message-body').scrollTop = messages.scrollHeight;
        // }
        // qty = results.length
        
        document.querySelector(`.${status}`).innerHTML = html;

    }
    request.send();
}

