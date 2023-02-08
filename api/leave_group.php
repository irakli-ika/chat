<?php
include "../db.php";
include "../functions.php";

if(isset($_POST['group_id']) && isset($_POST['user_id'])){
    $group_id = $_POST['group_id'];
    $user_id = $_POST['user_id'];
    $conversation_members = getDataWithCondition($db, 'receiver', "`conversation_id` = {$group_id}", 'false');

    if(count($conversation_members) == 1) {
        // remove conversation
        deleteRecord($db, 'conversations', "`id` = {$group_id}", 'false');
    } else {
        // leave group
        deleteRecord($db, "receiver", "`conversation_id` = {$group_id} && `user_id` = {$user_id}", 'true');
    }

}