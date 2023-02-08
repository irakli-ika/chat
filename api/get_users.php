<?php
include "../db.php";
include "../functions.php";

$receiver_id = $_GET['receiver'];

getDataWithLeftJoinCondition($db, "receiver", "conversations", "`receiver`.`conversation_id` = `conversations`.`id`", "`receiver`.`user_id` = {$receiver_id}", 'true');

// getDataWithMultipleLeftJoinCondition($db, "receiver", "conversations", "`receiver`.`conversation_id`=`conversations`.`id`", "users", "`receiver`.`user_id` = `users`.`id`", "`receiver`.`user_id` = {$receiver_id}", 'true');