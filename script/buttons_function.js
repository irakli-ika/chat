// delete message
const openDelModal = (e) => {
    e.target.nextElementSibling.classList.toggle('show')
}
const deleteMessage = (id) => {
    if (confirm('დარწმუნებული ხართ?')) {
        $.ajax({    
            type: "POST",
            url: "api/delete_message.php", 
            data:{deleteId:id},            
            dataType: "html",                  
            success: function(data){
            }
        });
    }
}

// delete conversation
const deleteConversation = (conversation_id, user_id) =>{
    if (confirm('დარწმუნებული ხართ?')) {
        $.ajax({    
            type: "POST",
            url: "api/delete_conversation.php", 
            data:{conversation_id, user_id},            
            dataType: "html",                  
            success: function(data){
                leftLoader.style.display = 'block';
                document.querySelector('.message-box').style.display = 'none';
                document.querySelector('.message-box-logo').style.display = 'flex';
            }
        });
    }
}

// leave group
const leaveGroup = (group_id, user_id) => {
    if (confirm('დარწმუნებული ხართ?')) {
        $.ajax({    
            type: "POST",
            url: "api/leave_group.php", 
            data:{group_id, user_id},            
            dataType: "html",                  
            success: function(data){
                leftLoader.style.display = 'block';
                document.querySelector('.message-box').style.display = 'none';
                document.querySelector('.message-box-logo').style.display = 'flex';
            }
        });
    }
}