<?php

session_start();

$token = null;

if(isset($_SESSION['token'])) {
    $token = $_SESSION['token'];
}
$_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(!isset($_POST['token']) || $_POST['token'] !== $token) {
        $error = '不正な処理が行われました';
        include(ERROR_PATH . '401.php');
        exit;
    }
    unset($_REQUEST['token']);
    unset($_POST['token']);
    $_SESSION['old']['post'] = $_POST;
}
