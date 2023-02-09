<?php
/* セッションから値を受け取るところから */
session_start();
$error_mes = $_SESSION['flash']["error_mes"] ?? [];
$name = $_SESSION['flash']["name"] ?? '';
unset($_SESSION['flash']);
//viewの読み込み
require_once("./view/view_signup.php");
