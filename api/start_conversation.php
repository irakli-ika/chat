<?php
include "../db.php";
include "../functions.php";

if (isset($_POST['user_id']) && !empty($_POST['user_id']) && isset($_POST['receiver_id']) && !empty($_POST['receiver_id'])) {
    $user_id = $_POST['user_id'];
    $receiver_id = $_POST['receiver_id'];

    $user = getDataWithCondition($db, 'receiver', "`user_id` = {$user_id}", 'false');
    $receiver = getDataWithCondition($db, 'receiver', "`user_id` = {$receiver_id}", 'false');

    function createConversation($db, $user_id, $receiver_id)
    {
        $new_conversation_id = (insertFieldsGetId($db, 'conversations', "`admin_id`, `is_group`", "'{$user_id}', 'false'"));
        if ($new_conversation_id) {
            insertFields($db, 'receiver', "`user_id`, `conversation_id`", "'{$user_id}', '{$new_conversation_id}'");
            insertFields($db, 'receiver', "`user_id`, `conversation_id`", "'{$receiver_id}', '{$new_conversation_id}'");
            echo json_encode(['status' => 'created', 'receiver' => $receiver_id]);
        }
    }
    
    if ($user && $receiver) {
        $exist = false;
        foreach ($user as $conversation_id) {
            foreach ($receiver as $rec_conversation_id) {
                if ($conversation_id['conversation_id'] == $rec_conversation_id['conversation_id']) $exist = true;
            }
        }
        if ($exist) {
            echo json_encode(['status' => 'created', 'receiver' => $receiver_id]);
        }else {
            createConversation($db, $user_id, $receiver_id);
            }
    } else {
        createConversation($db, $user_id, $receiver_id);
    }
}