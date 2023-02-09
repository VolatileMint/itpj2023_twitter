<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <title>ユーザー新規登録</title>
</head>

<body>
    <div class="test">
        <h1>新規登録</h1>
        <?php foreach ($error_mes as $v) : ?>
            <div class="alert alert-warning" role="alert"><?= $v ?></div>
        <?php endforeach; ?>
        <form action="./signup_check.php" method="post">
        <div class="form-group">
                <label for="exampleInputEmail1">ユーザー名</label>
                <input name="name" value="<?= $name ?>" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter username">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">パスワード(4文字以上)</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
            </div><div class="form-group">
                <label for="exampleInputPassword1">パスワード確認</label>
                <input type="password" name="password2" class="form-control" id="exampleInputPassword1" placeholder="Password again">
            </div>
            <input type="submit" class="btn btn-primary" value="登録する">
                <a href="index.php" class="btn btn-outline-primary">戻る</a>
        </form>
    </div>
</body>

</html>