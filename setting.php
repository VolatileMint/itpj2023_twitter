<?php
//モデルの読み込み
require_once("./model/func.php");
session_start();
$user = $_SESSION['auth'] ?? [];
if (count($user) == 0) {
    header('Location:index.php');
}
$auth_user_name = $user['name'];
$new_name = filter_input(INPUT_POST, "name");
$description = filter_input(INPUT_POST, 'description');
$error_mes = [];

$new_user = [];
if ($new_name != '') {
    if (nameConflict($new_name)) {
        $error_mes[] = "同じ名前が使われています";
    } else {
        $new_user['name'] = $new_name;
        $auth_user_name = $new_name;
    }
}
if ($description != '') {
    $new_user['description'] = $description;
}

//画像の取得
$image = $_FILES;
$filename = $image["icon"]["name"]; //ファイル名
$type = $image["icon"]["type"]; //ファイルタイプ　.jpg .png;
$tmp_name = $image["icon"]["tmp_name"]; //仮アップした場所
$error = $image["icon"]["error"]; //エラー
$size = $image["icon"]["size"]; //ファイルサイズ
if ($error == 0) {
    if ($size > 1024000) {
        $error_mes[] = "サイズが大きすぎます";
    }
    if ($type != 'image/jpeg') {
        $error_mes[] = "jpegのみ対応しています";
    }
    if (empty($error_mes)) {
        // 画像をアップロード
        $up_file = './user_icon/' . $filename;
        move_uploaded_file($tmp_name, $up_file);
        $new_user['icon'] = $filename;
    }
}
if (empty($error_mes) && count($new_user) > 0) {
    
    //アップデート
    $arr = ['id' => $user['id'], 'user' => $new_user];
    $result = updateUser($arr);
    if ($result) {
        $message = "プロフィールを更新しました";
        $_SESSION['flash']['message'] = $message;
        unset($_SESSION['auth']);
        $auth_user = userSerch($auth_user_name);
        unset($auth_user['password']);
        $_SESSION['auth'] = $auth_user;
    } else {
        $error_mes[] = "更新に失敗しました";
    }
}
$_SESSION['flash']['error_mes'] = $error_mes;

header('Location: mypage.php');
