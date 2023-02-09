<?php
require_once("./model/func.php");
session_start();
$user = $_SESSION['auth'] ?? [];
unset($_SESSION['flash']);
if (count($user) == 0) {
    header('Location:index.php');
}
$follow_id = $_POST['id'] ?? 0;
$follow_flg = $_POST['follow_flg'] ?? '';
if ($follow_id == 0 || $follow_flg == '') {
    header('Location:top.php');
    exit;
}

$target = [
    "login_id" => $user['id'],
    "follow_id" => $follow_id
];
$error_mes = [];
if ($follow_flg == 1) {
    // フォローする
    $result = follow($target);
    if ($result) {
        $message = "フォローしました";
    } else {
        $error_mes[] = "フォローに失敗しました";
    }
} else {
    // フォロー解除
    $result = unFollow($target);
    if ($result) {
        $message = "フォロー解除";
    } else {
        $error_mes[] = "フォロー解除に失敗しました";
    }
}

$_SESSION['flash']["error_mes"] = $error_mes;
$_SESSION['flash']["message"] = $message;
header("Location: top.php");
