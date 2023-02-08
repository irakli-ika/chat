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
        
        // changing content if has change
        if (qty < results.length) {
            const messages = document.querySelector('.message-body > div');
            messages.innerHTML = html;
            document.querySelector('.message-body').scrollTop = messages.scrollHeight;
            window.setInterval(getMessages, 2000);
        }
        qty = results.length
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

function getUserlist() {
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
        // console.log(message.conversation_id ? message.conversation_id : message.id);
        // console.log(message.is_group);
        document.querySelector('.users').childNodes.forEach(classLists => {
            if(classLists.classList) {
                classLists.classList.forEach(className => {
                    if (className == 'show') {   
                        // console.log(clas);
                    }
                })
            }
        })
        if (message.is_group) {
        //     return `<button class="member-list" data-id="${message.id}" data-isgroup="${message.is_group}">
        //     <div class="user-content">
        //         <div class="avatar-holder">
        //             <img src="" alt="">
        //         </div>
        //         <div class="user-details">
        //             <h1>${message.name}</h1>
        //             <!-- <p>hello I'm Irakli Qiria how are you</p> -->
        //         </div>
        //     </div>
        // </button>`
        console.log('ok');
        } else if(!message.is_group) {
            // return `<button class="member-list" data-id="${message.conversation_id}" data-isgroup="${'false'}">
            //         <div class="user-content">
            //             <div class="avatar-holder">
            //                 <img src="" alt="">
            //             </div>
            //             <div class="user-details">
            //                 <?php if ($user['is_group'] != 'true') :?>
            //                     <h1><?=getChatUserInstance($user, 'name', $db, $auth)?> <?=getChatUserInstance($user, 'last_name', $db, $auth)?></h1>
            //                     <!-- <p>hello I'm Irakli Qiria how are you</p> -->
            //                 <?php else : ?>
            //                     <h1><?=getChatUserInstance($user, 'name', $db, $auth)?></h1>
            //                     <!-- <p>hello I'm Irakli Qiria how are you</p> -->
            //                 <?php endif;?>
            //             </div>
            //         </div>
            //     </button>`
                console.log('no');
        } else {
            // return `<button class="member-list" data-id="${message.conversation_id ?? message.id}" data-isgroup="${message.is_group ?? 'false'}">
            //         <div class="user-content">
            //             <div class="avatar-holder">
            //                 <img src="" alt="">
            //             </div>
            //             <div class="user-details">
            //                 <?php if ($user['is_group'] != 'true') :?>
            //                     <h1><?=getChatUserInstance($user, 'name', $db, $auth)?> <?=getChatUserInstance($user, 'last_name', $db, $auth)?></h1>
            //                     <!-- <p>hello I'm Irakli Qiria how are you</p> -->
            //                 <?php else : ?>
            //                     <h1><?=getChatUserInstance($user, 'name', $db, $auth)?></h1>
            //                     <!-- <p>hello I'm Irakli Qiria how are you</p> -->
            //                 <?php endif;?>
            //             </div>
            //         </div>
            //     </button>`
                console.log('yes');
        }
        }).join('');
        
        // changing content if has change
        // if (qty < results.length) {
        //     const messages = document.querySelector('.message-body > div');
        //     messages.innerHTML = html;
        //     document.querySelector('.message-body').scrollTop = messages.scrollHeight;
        //     window.setInterval(getMessages, 2000);
        // }
        // qty = results.length
        console.log(html);
    }
    request.send();
}

getUserlist()