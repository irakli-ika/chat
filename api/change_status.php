<?php
include "../db.php";
include "../functions.php";

if(isset($_POST['conversation_id']) && !empty($_POST['conversation_id'])){
    $conversation_id = $_POST['conversation_id'];
    $user_id = $_POST['user_id'];

    // if(getDataWithCondition($db, "conversations", "`id` = {$conversation_id}", 'false')[0]['is_group'] == "true") {
    //     if(getDataWithCondition($db, "conversations", "`id` = {$conversation_id}", 'false')[0]['is_group'] == "true") {
    //         updateField($db, "messages", "`received` = '0', `seen` = `seen` + 1", "`conversation_id` = {$conversation_id}", 'true');

    //     }
    //     updateField($db, "messages", "`received` = '0', `seen` = `seen` + 1", "`conversation_id` = {$conversation_id}", 'true');

    // } else {
    //     updateField($db, "messages", "`received` = '0', `seen` = '1'", "`conversation_id` = {$conversation_id}", 'true');
    // }
    $unreader_messages = getDataWithCondition($db, 'received_messages', "`conversation_id` = {$conversation_id} && `receiver_id` = {$user_id}", 'false');
    if (!empty($unreader_messages)) {
        foreach ($unreader_messages as $message) {
            deleteRecord($db, 'received_messages', "`id` = {$message['id']}", 'true');
            updateField($db, 'messages', "`seen` = 1", "`conversation_id` = {$conversation_id} && `sender_id` != {$user_id}", 'true');
        }
    }


}