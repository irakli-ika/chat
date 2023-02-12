<?php
include "../db.php";
include "../functions.php";

if(isset($_GET['user_id']) && !empty($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    getDataWithCondition($db, 'received_messages', "`receiver_id` = {$user_id}", 'true');
}