<?php
//モデルの読み込み
require_once("./model/func.php");
session_start();

$body = filter_input(INPUT_POST, "body");
$user = $_SESSION['auth'] ?? [];
$error_mes = [];

// 
if ($body == null) {
    $error_mes[] = "本文がありません";
}
if (empty($error_mes)) {
    $tweet = ['user_id' => $user['id'], 'body' => $body];
    //画像の取得
    $image = $_FILES;
    $filename = $image["image"]["name"]; //ファイル名
    $type = $image["image"]["type"]; //ファイルタイプ　.jpg .png;
    $tmp_name = $image["image"]["tmp_name"]; //仮アップした場所
    $error = $image["image"]["error"]; //エラー
    $size = $image["image"]["size"]; //ファイルサイズ
    if ($error == 0 && $size < 2048000) {

        if ($type == 'image/jpeg') {
            $up_file = './image/' . $filename;
            move_uploaded_file($tmp_name, $up_file);
            $tweet += array('image' => $filename);
        }
    }
    $result = addTweet($tweet);
    if ($result) {
        $message = "ツイートしました";
        $_SESSION['flash']['message'] = $message;
    } else {
        $error_mes[] = "ツイートに失敗しました";
    }
}
$_SESSION['flash']['error_mes'] = $error_mes;

header('Location: top.php');
