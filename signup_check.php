<?php
//モデルの読み込み
require_once("./model/func.php");

session_start();

$name = filter_input(INPUT_POST, "name");
$password = filter_input(INPUT_POST, "password");
$password2 = filter_input(INPUT_POST, "password2");
$error_mes = [];
// validate
if ($name == null) {
    $error_mes[] = "名前が入力されていません";
}
if ($password == null) {
    $error_mes[] = "パスワードが入力されていません";
}
if (strlen($password) < 4) {
    $error_mes[] = "パスワードの長さが足りません";
}
if ($password !== $password2) {
    $error_mes[] = "パスワードが一致しません";
}

if (empty($error_mes)) {
    //同名ユーザがいるかチェック
    if (nameConflict($name)) {
        $error_mes[] = "既に同じ名前が使われています";
    } else {
        // パスワードをハッシュ化
        $hashed_passwd = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);

        // ユーザーを登録する
        $user = ['name' => $name, 'pass' => $hashed_passwd];
        $result = addUser($user);
        if ($result) {
            unset($_SESSION['flash']);
            $_SESSION['flash']['message'] = "ユーザーの登録に成功しました";
            header('Location: index.php');
            exit;
        }
        $error_mes[] = "新規登録に失敗しました";
    }
}
$_SESSION['flash']["error_mes"] = $error_mes;
$_SESSION['flash']['name'] = $name;
header('Location: signup.php');
