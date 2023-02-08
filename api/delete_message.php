<?php
include "../db.php";
include "../functions.php";

if(isset($_POST['deleteId'])){
    $id= $_POST['deleteId'];
    deleteRecord($db, "messages", "`id` = $id", 'true');
}