<?php
include "../db.php";
include "../functions.php";

$conversation_id = $_GET['conversation_id'];
$user_id = $_GET['user_id'];

// getDataWithLeftJoinCondition($db, "messages", "users", "`users`.`id` = `messages`.`sender_id`", "`conversation_id` = {$conversation_id}", 'true');
$results = [];
$is_deleted = array();

foreach (getDataWithCondition($db, "removed_messages", "`user_id` = {$user_id}", "false") as $message) {
    $is_deleted [] = $message['message_id'];
}

if(!empty($is_deleted)) {
    $messages = getDataWithLeftJoinCondition($db, "messages", "users", "`users`.`id` = `messages`.`sender_id`", "`conversation_id` = {$conversation_id}", 'false');
    foreach($messages as $message){
        if(!in_array($message[0], $is_deleted)){
            foreach(getDataWithLeftJoinCondition($db, "messages", "users", "`users`.`id` = `messages`.`sender_id`", "`messages`.`id` = {$message[0]}", 'false') as $message) {
                $results[] = $message;
            }

        }
    };
} else {
    foreach(getDataWithLeftJoinCondition($db, "messages", "users", "`users`.`id` = `messages`.`sender_id`", "`conversation_id` = {$conversation_id}", 'false') as $message) {
        $results[] = $message;
    }
}

echo json_encode($results);