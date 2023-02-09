<?php
//モデルの読み込み
require_once("./model/func.php");

$page_name = "follower";
session_start();
$message = $_SESSION['flash']['message'] ?? '';
$error_mes = $_SESSION['flash']['error_mes'] ?? [];
$user = $_SESSION['auth'] ?? [];
unset($_SESSION['flash']);

if (count($user) == 0) {
    header('Location:index.php');
}
$flag = [$page_name, $user['id']];
$list = userList($flag);
if(count($list) == 0){
    $message = "対象のユーザーがいません";
}
// var_dump($list);
require_once("./view/view_userlist.php");
