<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <title>ログイン画面</title>
</head>

<body>
    <div class="test">
        <h1>TwitterApp</h1>
        <h2>ログイン画面</h2>
        <?= $message ?>
        <?php foreach ($error_mes as $v) : ?>
            <div class="alert alert-danger" role="alert"><?= $v ?></div>
        <?php endforeach; ?>

        <form action="login.php" method="post">
            <div class="form-group">
                <label for="exampleInputEmail1">ユーザー名</label>
                <input name="name" value="<?= $name ?>" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter username">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">パスワード</label>
                <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
            </div>
                <input type="submit" class="btn btn-primary" value="ログイン">
                <a href="signup.php" class="btn btn-outline-primary">新規登録</a>
        </form>
    </div>
</body>

</html>