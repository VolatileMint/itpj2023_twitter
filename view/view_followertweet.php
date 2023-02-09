<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/test.css">
    <title>Document</title>
</head>

<body>
    <h1>フォローユーザーのみ表示</h1>
    <div class="wrapper">
        <div class="header">
            <a href="mypage.php">
                <div class="headeruser">
                    <img src="user_icon/<?= $user['icon'] ?>" class="icon">
                    <p><span><?= $user['name'] ?></span></p>
                </div>
            </a>
            <a class="links" href="top.php"><i class="fa-solid fa-house fa-2x"></i><span>トップページ</span></a>
            <a class="links" href="followerlist.php"><i class="fa-solid fa-hand-holding-heart fa-2x"></i><span>フォローリスト</span></a>
            <a class="links" href="followedlist.php"><i class="fa-regular fa-handshake fa-2x"></i><span>フォロワーリスト</span></a>
            <a class="links" href="userlist.php"><i class="fa-regular fa-solid fa-users fa-2x"></i><span>ユーザーリスト</span></a>
            <a class="links" href="logout.php"><i class="fa-solid fa-right-from-bracket fa-2x"></i><span>ログアウトする</span></a>
        </div>
        <div class="main">
            <?= $message ?>
            <?php foreach ($error_mes as $v) : ?>
                <div class="alert alert-warning" role="alert"><?= $v ?> </div>
            <?php endforeach; ?>
            <div class="addTweet">
                <form action="input.php" method="post" enctype="multipart/form-data">
                    <textarea class="form-control" name="body" id="exampleFormControlTextarea1" rows="4" placeholder="今どうしてる？"></textarea>
                    <input type="file" name="image">
                    <button type="submit" class="btn btn-primary send">ツイートする</button>
                </form>
            </div>
            <?php foreach ($list as $value) : ?>
                <div class="tweet">
                    <div class="line">
                        <a href="userpage.php?id=<?= $value['user_id']; ?>" class="useranker">
                            <img src="user_icon/<?= $value['icon'] ?>" class="icon">
                            <p class="user_name"><?php echo $value["name"] ?></p>
                        </a>
                        <p class="dtime"><?= date('Y年n月j日 G:i', strtotime($value["created_at"])); ?></p>
                    </div>
                    <p><?php echo $value["body"] ?></p>
                    <img src="image/<?php echo $value["image"] ?>" alt="">
                </div>
                <hr>
            <?php endforeach; ?>
        </div>
        <div class="search">
            <form class="form-inline my-2 my-lg-0" action="top.php" method="get">
                <input name="search" class="form-control mr-sm-2" type="search" placeholder="tweetの検索" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </div>
</body>

</html>