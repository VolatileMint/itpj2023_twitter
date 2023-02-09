<?php
//モデルの読み込み
require_once("./model/func.php");
session_start();

// セッション情報を取得
$user = $_SESSION['auth'] ?? [];
$message = $_SESSION['flash']['message'] ?? '';
$error_mes = $_SESSION['flash']['error_mes'] ?? [];
unset($_SESSION['flash']);

$user_id = $_GET['id'] ?? 0;

// ログインチェック
if (count($user) == 0) {
    header('Location:index.php');
}
// マイページに飛ばす
if ($user['id'] == $user_id) {
    header('Location:mypage.php');
}

// 表示するユーザーの情報取得
$show_user = getUser($user_id);
if ($show_user === false) {
    header('Location:top.php');
}
unset($show_user['password']); // パスワードは消しておく

// フォロー状況のチェック
$target = [
    "login_id" => $user['id'],
    "follow_id" => $user_id,
];
$check = followCheck($target);
// フォローしていない場合はfalseが返ってくる
if ($check === false) {
    $follow_flg = false;
} else {
    $follow_flg = true;
}
$single_list = singleList($user_id);
//viewの読み込み
require_once("./view/view_userpage.php");
