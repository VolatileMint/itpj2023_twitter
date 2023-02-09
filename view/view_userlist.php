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
    <h1>
        <?php
        switch ($page_name) {
            case "follower":
                echo "フォローしているユーザーの一覧";
                break;
            case "followed":
                echo "フォローされているユーザーの一覧";
                break;
            default:
                echo "ユーザーの一覧";
        }
        ?>

    </h1>
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
            <?php 
                if($message != ''){ 
                    echo "<div class='alert alert-primary' role='alert'>" . $message . "</div>";
                };
            ?>
            <?php foreach ($error_mes as $v) : ?>
                <div class="alert alert-warning" role="alert"><?= $v ?> </div>
            <?php endforeach; ?>
            <?php foreach ($list as $value) : ?>
                <div class="state">
                    <form action="follow.php" method="POST">
                        <input type="hidden" name="id" value="<?= $value['id']; ?>">
                        <?php if ($page_name == "follower" || $value['flag'] != false) : ?>
                            <input type="hidden" name="follow_flg" value="0">
                            <button type="submit" class="btn btn-danger send">フォロー解除</button>
                        <?php else : ?>
                            <input type="hidden" name="follow_flg" value="1">
                            <button type="submit" class="btn btn-primary send">フォローする</button>
                        <?php endif; ?>
                    </form>
                    <?php if ($value['follower_id'] == $user['id']) : ?>
                        <p>フォローされています</p>
                    <?php endif; ?>
                </div>
                <div class="users">
                    <div class="line">
                        <a href="userpage.php?id=<?= $value['id']; ?>" class="useranker">
                            <img src="user_icon/<?= $value['icon'] ?>" class="icon">
                            <p class="user_name"><?= $value["name"] ?></p>
                        </a>
                    </div>
                    <p class="description"><?= $value["description"] ?></p>
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