<?php
session_start();
$error_mes = $_SESSION['flash']["error_mes"] ?? [];
$message = $_SESSION['flash']['message'] ?? '';
$name = $_SESSION['flash']['name'] ?? '';
unset($_SESSION['flash']);

//viewの読み込み
require_once("./view/view_index.php");
