<?php
//モデルの読み込み
require_once("./model/db.php");

// ユーザーの新規登録
function addUser(array $user): bool
{
    $dbh = Db::getHandle();
    $sql = 'INSERT INTO `users` (name, password,icon) VALUE(:name,:pass,"default.jpg");';
    $pre = $dbh->prepare($sql);
    $pre->bindValue(":name", $user['name'], \PDO::PARAM_STR);
    $pre->bindValue(":pass", $user['pass'], \PDO::PARAM_STR);
    $result = $pre->execute();
    return $result;
}
// ユーザー情報の取得
function getUser(int $id)
{
    $dbh = Db::getHandle();
    $sql = 'SELECT * FROM users WHERE id=:id;';
    $pre = $dbh->prepare($sql);
    $pre->bindValue(":id", $id, \PDO::PARAM_INT);
    $pre->execute();
    $user = $pre->fetch();
    return $user;
}
/* ユーザー名の使用確認
 * 同名のユーザーがいる場合はtrue
 */
function nameConflict(string $name): bool
{
    $dbh = Db::getHandle();
    $sql = 'SELECT * FROM users WHERE name=:name;';
    $pre = $dbh->prepare($sql);
    $pre->bindValue(":name", $name, \PDO::PARAM_STR);
    $pre->execute();
    $count = $pre->fetchAll(PDO::FETCH_ASSOC);
    return (count($count) != 0);
}
/* ユーザーのリスト(follow,follower指定可)
 * $flag = ["follow or follower or all",userid]
 */
function userList(array $flag): array
{
    $dbh = Db::getHandle();
    // 指定がなければ全ユーザー取得
    if ($flag[0] == "all") {
        $sql = 'SELECT id,name,icon,description FROM users;';
        $pre = $dbh->prepare($sql);
        $pre->execute();
        $user_list = $pre->fetchAll(PDO::FETCH_ASSOC);
        return $user_list;
        // フォローしているユーザーのみ取得
    } elseif ($flag[0] == "follower") {
        $sql = 'SELECT users.id,users.name,users.icon,users.description,follows.follower_id, follows.followed_id
        FROM users 
        LEFT OUTER JOIN follows ON users.id = follows.followed_id 
        WHERE follows.follower_id=:id;';
        // フォローされているユーザーのみ取得
    } elseif ($flag[0] == "followed") {
        $sql = 'SELECT users.id,users.name,users.icon,users.description,follows.follower_id,follows.followed_id 
        FROM users 
        LEFT OUTER JOIN follows ON users.id = follows.follower_id 
        WHERE follows.followed_id=:id;';
    }
    $pre = $dbh->prepare($sql);
    $pre->bindValue(":id", $flag[1], \PDO::PARAM_INT);
    $pre->execute();
    $user_list = $pre->fetchAll(PDO::FETCH_ASSOC);
    return $user_list;
}
// ユーザー検索
function findUser(string $search): array{
    $dbh = Db::getHandle();
    $sql = 'SELECT * FROM users WHERE name LIKE :search;';
    $pre = $dbh->prepare($sql);
    $pre->bindValue(":search", '%' . $search . '%', \PDO::PARAM_INT);
    $pre->execute();
    $user_list = $pre->fetchAll(PDO::FETCH_ASSOC);
    return $user_list;
}
// ログイン用
function userSerch(string $name): array
{
    $dbh = Db::getHandle();
    $sql = 'SELECT * FROM users WHERE name=:name;';
    $pre = $dbh->prepare($sql);
    $pre->bindValue(":name", $name, \PDO::PARAM_STR);
    $pre->execute();
    $user = $pre->fetch();
    return $user;
}
// ユーザー情報の更新
function updateUser(array $arr): bool
{
    $id = $arr['id'];
    $user = $arr['user'];
    $dbh = Db::getHandle();
    $keys = implode(", ", array_keys($user)); // (key, key, key)
    $binds = [];
    $sqls = [];
    foreach ($user as $k => $v) {
        $sqls[] .= $k . '=:' . $k;
        $binds += [":" . $k => $v];
    }
    $placeholder = implode(", ", $sqls); // (key=:key, :key=key, key=:key)
    $sql = "UPDATE `users` SET $placeholder WHERE id=:id;";
    $pre = $dbh->prepare($sql);
    $pre->bindValue("id", $id, \PDO::PARAM_INT);
    foreach ($binds as $key => $val) {
        $pre->bindValue($key, $val, \PDO::PARAM_STR);
    }
    $result = $pre->execute();
    return true;
}

/* Tweet */
// 全ユーザーのツイート取得
function getTweet(): array
{
    $dbh = Db::getHandle();
    $sql = 'SELECT tweets.id, tweets.user_id, tweets.body, tweets.image, tweets.created_at, users.name, users.icon 
        FROM tweets LEFT OUTER JOIN users ON tweets.user_id = users.id 
        ORDER BY tweets.created_at DESC';
    $pre = $dbh->prepare($sql);
    $pre->execute();
    $tweetList = $pre->fetchAll(PDO::FETCH_ASSOC);
    return $tweetList;
}
// フォローユーザーのツイート取得
function followerTweet(int $id): array
{
    $dbh = Db::getHandle();
    $sql = 'SELECT tweets.id, tweets.user_id, tweets.body, tweets.image, tweets.created_at, users.name, users.icon
        FROM tweets 
        LEFT OUTER JOIN users ON tweets.user_id = users.id 
        LEFT OUTER JOIN follows ON users.id = follows.followed_id
        WHERE follows.follower_id = :follower_id OR tweets.user_id = :auth_id
        ORDER BY tweets.created_at DESC';
    $pre = $dbh->prepare($sql);
    $pre->bindValue(":follower_id", $id, \PDO::PARAM_INT);
    $pre->bindValue(":auth_id", $id, \PDO::PARAM_INT);
    $pre->execute();
    $tweetList = $pre->fetchAll(PDO::FETCH_ASSOC);
    return $tweetList;
}
// 1ユーザのツイート取得
function singleList(int $id): array
{
    $dbh = Db::getHandle();
    $sql = 'SELECT tweets.id, tweets.user_id, tweets.body, tweets.image, tweets.created_at, users.name, users.icon 
        FROM tweets  INNER JOIN users ON tweets.user_id = users.id 
        WHERE tweets.user_id=:id 
        ORDER BY tweets.created_at DESC';
    $pre = $dbh->prepare($sql);
    $pre->bindValue(":id", $id, \PDO::PARAM_INT);
    $pre->execute();
    $tweetList = $pre->fetchAll(PDO::FETCH_ASSOC);
    return $tweetList;
}
function searchTweet(string $search): array {
    $dbh = Db::getHandle();
    $sql = 'SELECT tweets.id, tweets.user_id, tweets.body, tweets.image, tweets.created_at, users.name, users.icon 
        FROM tweets INNER JOIN users ON tweets.user_id = users.id 
        WHERE tweets.body LIKE :search
        ORDER BY tweets.created_at DESC';
    $pre = $dbh->prepare($sql);
    $pre->bindValue(":search", '%' . $search . '%', \PDO::PARAM_INT);
    $pre->execute();
    $tweetList = $pre->fetchAll(PDO::FETCH_ASSOC);
    return $tweetList;
}
// ツイート作成
function addTweet(array $tweet): bool
{
    $keys = implode(", ", array_keys($tweet)); // (key, key, key)
    $bindtweet = [];
    foreach ($tweet as $k => $v) {
        $bindtweet += [":" . $k => $v];
    }
    $placeholder = implode(", ", array_keys($bindtweet)); // (:key, :key, :key)
    $dbh = Db::getHandle();
    $sql = "INSERT INTO `tweets`($keys) VALUE($placeholder);";
    $pre = $dbh->prepare($sql);
    foreach ($bindtweet as $key => $val) {
        if ($key == 'user_id') {
            $pre->bindValue($key, $val, \PDO::PARAM_INT);
        } else {
            $pre->bindValue($key, $val, \PDO::PARAM_STR);
        }
    }
    $result = $pre->execute();
    return $result;
}

/* follows */
function follow(array $target)
{
    $dbh = Db::getHandle();
    $sql = "INSERT INTO `follows`(follower_id, followed_id) VALUE(:follower_id,:followed_id);";
    $pre = $dbh->prepare($sql);
    $pre->bindValue(':follower_id', $target['login_id'], \PDO::PARAM_INT);
    $pre->bindValue(':followed_id', $target['follow_id'], \PDO::PARAM_INT);
    $result = $pre->execute();
    return $result;
}
function unFollow(array $target)
{
    $dbh = Db::getHandle();
    $sql = "DELETE FROM `follows` WHERE follower_id=:follower_id AND followed_id=:followed_id;";
    $pre = $dbh->prepare($sql);
    $pre->bindValue(':follower_id', $target['login_id'], \PDO::PARAM_INT);
    $pre->bindValue(':followed_id', $target['follow_id'], \PDO::PARAM_INT);
    $result = $pre->execute();
    return $result;
}

function followCheck(array $target)
{
    $dbh = Db::getHandle();
    $sql = "SELECT * FROM `follows` WHERE follower_id=:follower_id AND :followed_id=followed_id;";
    $pre = $dbh->prepare($sql);
    $pre->bindValue(':follower_id', $target['login_id'], \PDO::PARAM_INT);
    $pre->bindValue(':followed_id', $target['follow_id'], \PDO::PARAM_INT);
    $result = $pre->execute();
    return $pre->fetch();
}
