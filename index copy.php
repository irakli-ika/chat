<?php
    include "db.php";
    include "functions.php";
    include "helpers.php";

    $user_id = $_GET['user'];

    // CSRF token
    $token = $_SESSION['token'] = md5(uniqid(mt_rand(), true));
    // Login user
    $auth = $_SESSION['auth'] = [...getDataWithCondition($db, 'users', "`id` = {$user_id}", 'false')[0]];

    $users_list = getDataWithLeftJoinCondition($db, "receiver", "conversations", "`receiver`.`conversation_id` = `conversations`.`id`", "`receiver`.`user_id` = {$auth['id']} && `remove` != 1", 'false');

?>  
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="loader/loader.css">
    <title>Chat</title>
</head>
<body>
    <h1 class="h1">Live Chat</h1>
    <section>
        <aside class="left-side">
            <nav class="left-side-navbar">
                <button class="navbar-active" data-role='all'>ყველა</button>
                <button data-role='dialog'>დიალოგი</button>
                <button data-role='group'>ჯგუფები</button>
            </nav>
            <div class="users">
                <div class="all">
                    <?php foreach ($users_list as $user) : ?>
                    
                        <button class="member-list" data-id="<?=getChatUserInstance($user, 'id', $db, $auth)?>" data-isgroup="<?=$user['is_group']?>">
                            <div class="user-content">
                                <div class="avatar-holder">
                                    <img src="" alt="">
                                </div>
                                <div class="user-details">
                                    <?php if ($user['is_group'] != 'true') :?>
                                        <h1><?=getChatUserInstance($user, 'name', $db, $auth)?> <?=getChatUserInstance($user, 'last_name', $db, $auth)?></h1>
                                        <!-- <p>hello I'm Irakli Qiria how are you</p> -->
                                    <?php else : ?>
                                        <h1><?=getChatUserInstance($user, 'name', $db, $auth)?></h1>
                                        <!-- <p>hello I'm Irakli Qiria how are you</p> -->
                                    <?php endif;?>
                                </div>
                            </div>
                        </button>
                    <?php endforeach; ?>
                </div>
                <div class="dialog">
                    <?php foreach ($users_list as $user) : ?>
                        <?php if ($user['is_group'] != 'true') :?>
                            <button class="member-list" data-id="<?=getChatUserInstance($user, 'id', $db, $auth)?>" data-isgroup="false">
                                <div class="user-content">
                                    <div class="avatar-holder">
                                        <img src="" alt="">
                                    </div>
                                    <div class="user-details">
                                        <h1><?=getChatUserInstance($user, 'name', $db, $auth)?> <?=getChatUserInstance($user, 'last_name', $db, $auth)?> </h1>
                                        <!-- <p>hello I'm Irakli Qiria how are you</p> -->
                                    </div>
                                </div>
                            </button>
                        <?php endif;?>
                    <?php endforeach; ?>
                </div>
                <div class="group">
                    <?php foreach ($users_list as $user) : ?>
                        <?php if ($user['is_group'] === 'true') :?>
                            <button class="member-list" data-id="<?=getChatUserInstance($user, 'id', $db, $auth)?>" data-isgroup="true">
                                <div class="user-content">
                                    <div class="avatar-holder">
                                        <img src="" alt="">
                                    </div>
                                    <div class="user-details">
                                        <h1><?=getChatUserInstance($user, 'name', $db, $auth)?></h1>
                                        <!-- <p>hello I'm Irakli Qiria how are you</p> -->
                                    </div>
                                </div>
                            </button>
                        <?php endif;?>
                    <?php endforeach; ?>
                </div>
            </div>
        </aside>
        <aside class="right-side">
            <div class="message-box-logo"></div>
            <div class="message-box">
                <div class="top-side">
                    <div>
                        <div class="avatar-holder"></div>
                        <span class="user-name"></span>
                    </div>
                    <div>
                        <i class="fa-solid fa-ellipsis-vertical deleteMessage" onclick="openDelModal(event)"></i>
                        <div class="deleteModal">
                            <button onclick="deleteConversation(event.target.dataset.id, <?=$auth['id']?>)" id="deleteConversation" data-id="">წაშლა</button>
                            <button onclick="leaveGroup(event.target.dataset.id, <?=$auth['id']?>)" id="leaveGroup" data-id="">ჯგუფის დატოვება</button>
                        </div>
                    </div>
                </div>
                <!-- message-body -->
                <div class="message-body">
                     <?php include 'loader/loader.php' ?>
                    <div>
                        <!-- render message in here -->
                    </div>
                </div>
                <!-- writing space -->
                <div class="chatbox-footer">
                    <form method="post" id="message-inner">
                        <div class="custom-form-group">
                            <input type="hidden" name="token" value="<?php echo $token ?? '' ?>">
                            <input type="text" name="message" placeholder='Type a message...' autocomplete="off"></input>
                            <button type="submit"><i class='bx bx-send'></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </aside>
    </section>
    <script type="text/javascript">
        const user_id = <?=$auth['id']?>
    </script>
    <script src="script/message_tmp.js"></script>
    <script src="script/helper.js"></script>
    <script src="script/script.js"></script>
    <script src="script/buttons_function.js"></script>
</body>
</html>