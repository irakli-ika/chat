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
                console.log(data);
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
                console.log(data);
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
                console.log(data);
            }
        });
    }
}