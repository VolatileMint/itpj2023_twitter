<?php
//モデルの読み込み
require_once("./model/func.php");

$page_name = "followed";
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
foreach ($list as $k => $v) {
    // フォロー状況のチェック
    $target = [
        "login_id" => $user['id'],
        "follow_id" => $v['id'],
    ];
    // フォローしていない場合はfalseが返ってくる
    $v["flag"]  = followCheck($target);
    $list[$k] = $v;
}
if(count($list) == 0){
    $message = "対象のユーザーがいません";
}
// var_dump($list);
//viewの読み込み
require_once("./view/view_userlist.php");
