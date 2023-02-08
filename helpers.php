<?php

function getChatUserInstance($conversation, $request, $db, $auth)
{
    $receiverInstance = '';
    

    if ($conversation['is_group'] != 'true') {
        $reveicer_id = getDataWithCondition($db, 'receiver', "`conversation_id` = {$conversation['conversation_id']} && `user_id` != {$auth['id']}", "false");
        
        $receiverInstance = getDataWithCondition($db, 'users', "`id` =" . $reveicer_id[0]['user_id'], "false");
        
            if (isset($request)) {
                if ($request == 'id') {
                    return $conversation['conversation_id'];
                } 
                else {

                    return $receiverInstance[0][$request];
                }
           }
    } else {
        $receiverInstance = getDataWithCondition($db, 'conversations', "`id` = {$conversation['conversation_id']}", "false");

        if (isset($request)) {
            return $receiverInstance[0][$request];
        }
   }
    
}