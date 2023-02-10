<?php
include "../db.php";
include "../functions.php";

$sender_id = $_POST['sender_id'];
$conversation_id = $_POST['conversation_id'];
$message = $_POST['message'];
$received = 1;
$seen = 0;

$receiver = getDataWithCondition($db, 'receiver', "`conversation_id` = {$conversation_id} ", 'false');
$users_id = getDataWithCondition($db, 'receiver', "`conversation_id` = {$conversation_id} && `user_id` != {$sender_id}", 'false');

// foreach ($receiver as $value) {
//     if ($value['remove'] == 1) {
        
//         updateField($db, 'receiver', "`remove` = 0", "`conversation_id` = $conversation_id && `user_id` = {$value['user_id']}", 'true');
        
//     }
// }

$message_id = insertFieldsGetId($db, 'messages', "`message`,`sender_id`, `conversation_id`, `received`, `seen`", "'{$message}', '{$sender_id}', '{$conversation_id}', '{$received}', '{$seen}'");

foreach($users_id as $user_id) {    
    insertFields($db, 'received_messages', "`message_id`,`user_id`, `conversation_id`", "'{$message_id}', '{$user_id['user_id']}', '{$conversation_id}'");
}