<?php
//モデルの読み込み
require_once("./model/func.php");

$page_name = "all";
session_start();
$message = $_SESSION['flash']['message'] ?? '';
$error_mes = $_SESSION['flash']['error_mes'] ?? [];
$user = $_SESSION['auth'] ?? [];
unset($_SESSION['flash']);

if (count($user) == 0) {
    header('Location:index.php');
}
$search = $_GET['search'] ?? '';

if($search != ''){
    $list = findUser($search);
    $message = $search . "の検索結果";
}else{
    $flag = [$page_name, $user['id']];
    $list = userList($flag);
}


//viewの読み込み
require_once("./view/view_alluser.php");
