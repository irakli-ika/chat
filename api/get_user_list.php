<?php
include "../db.php";
include "../functions.php";

$user_id = $_GET['user_id'];

$user_list = getDataWithLeftJoinCondition($db, "receiver", "conversations", "`receiver`.`conversation_id` = `conversations`.`id`", "`receiver`.`user_id` = {$user_id} && `remove` != 1", 'false');

$result = [];

foreach($user_list as $user) {
    $receiverInstance = '';
    
    if ($user['is_group'] != 'true') {
        $reveicer_id = getDataWithCondition($db, 'receiver', "`conversation_id` = {$user['conversation_id']} && `user_id` != {$user_id}", "false");
        $user_with_conversation = getDataWithLeftJoinCondition($db, "receiver", "users", "`receiver`.`user_id` = `users`.`id`", "`conversation_id` = {$user['conversation_id']} && `user_id` != {$user_id}", 'false');       

        foreach($user_with_conversation as $item) {
            $unread_message = getDataWithCondition($db, 'received_messages', "`conversation_id` = {$item['conversation_id']} && `receiver_id` = {$user_id}", "false");
            $data = $item;
            $data['unreaded']= count($unread_message);
            $result [] = $data;
        }
    } else {
        $receiverInstance = getDataWithCondition($db, 'conversations', "`id` = {$user['conversation_id']}", "false");
        $user_with_conversation = getDataWithLeftJoinCondition($db, "receiver", "conversations", "`receiver`.`conversation_id` = `conversations`.`id`", "`user_id` = {$user_id} && 'is_group' = 'true'", 'false');
        foreach($receiverInstance as $item) {
            $unread_message = getDataWithCondition($db, 'received_messages', "`conversation_id` = {$item['id']} && `receiver_id` = {$user_id}", "false");
            $data = $item;
            $data['unreaded']= count($unread_message);
            $result [] = $data;
        }
    }
}
echo json_encode($result);