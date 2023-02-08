<?php
define("DB",[
    // "name" => "chat",
    "name" => "multiple_chat",
    "user" => "root",
    "password" => "",
    "host" => "localhost"
]);

$db = @mysqli_connect(DB['host'], DB['user'], DB['password'], DB['name']);

if(mysqli_connect_errno()) {
    // echo mysqli_connect_error();
    exit('connection problem');
};