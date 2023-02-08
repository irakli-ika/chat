<?php
include "../db.php";
include "../functions.php";

$sender_id = $_POST['sender_id'];
$conversation_id = $_POST['conversation_id'];
$message = $_POST['message'];

$receiver = getDataWithCondition($db, 'receiver', "`conversation_id` = {$conversation_id} ", 'false');

foreach ($receiver as $value) {
    if ($value['remove'] == 1) {
        
        updateField($db, 'receiver', 'remove', 0, "`conversation_id` = $conversation_id && `user_id` = {$value['user_id']}", 'true');
        
    }
}

insertFields($db, 'messages', "`message`,`sender_id`, `conversation_id`", "'{$message}', '{$sender_id}', '{$conversation_id}'");