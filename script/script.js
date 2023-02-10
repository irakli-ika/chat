function getMessages(){
    // let seen = false;
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
                            <div class="message-details">
                                <div class="timestamp">1:11</div>
                            </div>
                        </div>
                    </div>`
            } else {
                return `<div class="sent-message">
                            <div>
                                <div class="message-author">
                                    <a href="#">${message.name} ${message.last_name}</a>
                                </div>
                                <p>${message.message}</p>
                                <div class="message-details">
                                    <div class="timestamp">1:11</div>
                                    <div class="${message.seen == 1 ? 'show' : 'hidden'}">seen</div>
                                </div>
                                <i class="fa-solid fa-ellipsis-vertical deleteMessage" onclick="openDelModal(event)" data-message-id=${message[0]}></i>
                                <div class="deleteModal">
                                    <button onclick="deleteMessage(${message[0]})">წაშლა</button>
                                </div>
                            </div>
                        </div>`
            }
        }).join('');
        const messages = document.querySelector('.message-body > div');


        if (document.getElementById(`${conversation_id}`).childElementCount != results.length) {
            messages.innerHTML = html;
            document.querySelector('.message-body').scrollTop = messages.scrollHeight;
        }
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
        console.log(request.responseText)
        
        
    }
    if (message.length > 0) {
        request.send(data);
    }
});


// get user list
function getUserlist() {
    const userListAll = document.querySelector('.all');
    const userListDialog = document.querySelector('.dialog');
    const userListGroup = document.querySelector('.group');
    let unreaded = false;
    const request = new XMLHttpRequest();
    request.addEventListener("readystatechange", () => {
        if (request.readyState === 4 && request.status === 200) {
            leftLoader.style.display = 'none';
        }
      });
    request.open("GET", `api/get_user_list.php?user_id=${user_id}`);
  
    request.onload = function(){
      const results = JSON.parse(request.responseText);
      const html = results.map(function(message){
        message.unreaded > 0 ? unreaded = true : false;
        if (userListAll.classList.contains('show')) {
            return `<button class="member-list" onclick="openMessage(this)" data-id="${message.conversation_id ?? message.id}" data-isgroup="${message.is_group ?? 'false'}">
                        <div class="user-content">
                            <div class="avatar-holder">
                                <img src="" alt="">
                            </div>
                            <div class="user-details">
                                <h1>${message.is_group ? message.name : message.name + " " + message.last_name}</h1>
                                <!-- <p>hello I'm Irakli Qiria how are you</p> -->
                            </div>
                            <div class="unread_message" style="${message.unreaded > 0 ? 'display: flex' : 'display: none'}">${message.unreaded > 0 ? message.unreaded : ''}</div>
                        </div>
                    </button>`
        } else if(userListDialog.classList.contains('show')) {
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
                                <div class="unread_message" style="${message.unreaded > 0 ? 'display: flex' : 'display: none'}">${message.unreaded > 0 ? message.unreaded : ''}</div>
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
                                    <div class="unread_message" style="${message.unreaded > 0 ? 'display: flex' : 'display: none'}">${message.unreaded > 0 ? message.unreaded : ''}</div>
                                </div>
                            </button>`
            }
        }
        }).join('');
        if (userListAll.classList.contains('show')) {
            if (userListAll.childElementCount != results.length || unreaded) {
                userListAll.innerHTML = html;
                unreaded = false;
            }
        } else if(userListDialog.classList.contains('show')) {
            if (userListDialog.childElementCount != results.length || unreaded) {
                userListDialog.innerHTML = html;
                unreaded = false
            }
        } else {
            if (userListGroup.childElementCount != results.length || unreaded) {
                userListGroup.innerHTML = html;
                unreaded = false;
            }
        }
        
    }
    request.send();
}


function changeStatus(conversation_id) {
    const data = new FormData();
    data.append('conversation_id', conversation_id);
    data.append('user_id', user_id);
    
    const request = new XMLHttpRequest();
    request.open('POST', 'api/change_status.php');
    
    request.onload = function(){

    }
    
    request.send(data);
}