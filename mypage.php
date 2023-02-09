<?php
//モデルの読み込み
require_once("./model/func.php");
session_start();
// ログインチェック
$user = $_SESSION['auth'] ?? [];
if (count($user) == 0) {
    header('Location:index.php');
}
// セッション情報を取得
$message = $_SESSION['flash']['message'] ?? '';
$error_mes = $_SESSION['flash']['error_mes'] ?? [];
unset($_SESSION['flash']);

$single_list = singleList($user['id']);
//viewの読み込み
require_once("./view/view_mypage.php");
