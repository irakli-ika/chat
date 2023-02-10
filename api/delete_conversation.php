<?php
include "../db.php";
include "../functions.php";

if(isset($_POST['conversation_id'])&& isset($_POST['user_id'])){
    $conversation_id = $_POST['conversation_id'];
    $user_id = $_POST['user_id'];
    delete_conversation($db, $conversation_id, $user_id);
}
// remove data query
function delete_conversation($db, $conversation_id, $user_id){
    $receiver = getDataWithCondition($db, 'receiver', "`conversation_id` = {$conversation_id} && `remove` != 1", 'false');
    $conversation_members = getDataWithCondition($db, 'receiver', "`conversation_id` = {$conversation_id}", 'false');
    $messages = getDataWithCondition($db, 'messages', "`conversation_id` = {$conversation_id}", 'false');
    
    foreach ($receiver as $value) {
        if(count($receiver) == 1) {
            if ($value['user_id'] == $user_id) {
                // remove conversation
                deleteRecord($db, 'conversations', "`id` = {$conversation_id}", 'false');
            }
        } else {
            if ($value['user_id'] == $user_id) {
                if (!$value['remove']) {
                    // remove receiver
                    updateField($db, 'receiver', "`remove` = 1", "`conversation_id` = $conversation_id && `user_id` = {$user_id}", 'true');
                     
                    foreach($messages as $message) {
                        // remove messages
                        insertFields($db, 'removed_messages', "`user_id`, `message_id`", "{$user_id}, {$message['id']}");
                        
                        $removed_messages = getDataWithCondition($db, 'removed_messages', "`message_id` = {$message['id']}", 'false');
                        foreach($removed_messages as $message_id) {
                            if(count($removed_messages) == count($conversation_members)) {
                                // removed message forever
                                deleteRecord($db, 'messages', "`id` = {$message_id['message_id']}", 'false');
                            }
                        }
                    }
                }
            }
        }
    }
}