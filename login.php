<?php
//モデルの読み込み
require_once("./model/func.php");

session_start();
$name = filter_input(INPUT_POST, "name");
$password = filter_input(INPUT_POST, "password");
$result = false;
$error_mes = [];
if ($name == null) {
    $error_mes[] = "名前が入力されていません";
}
if ($password == null) {
    $error_mes[] = "パスワードが入力されていません";
}
if (empty($error_mes)) {
    // ログインチェック
    $user = userSerch($name);
    // 存在しない場合falseが返ってくる
    if ($user != false && password_verify($password, $user['password'])) {
        // sessionにユーザー情報を保存
        unset($_SESSION['flash']);
        unset($user['password']);
        $_SESSION['auth'] = $user;
        header('Location: top.php');
        exit;
    }
    $error_mes[] = "ユーザー名またはパスワードが違います";
}

$_SESSION['flash']["error_mes"] = $error_mes;
$_SESSION['flash']['name'] = $name;
header('Location: index.php');
