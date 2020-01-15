<?php

session_start();

$csrfToken = null;

if(isset($_SESSION['csrf'])) {
    $csrfToken = $_SESSION['csrf'];
}

$_SESSION['flash']['old'] = [];
$new = isset($_SESSION['flash']['new']) ? $_SESSION['flash']['new'] : [];
$_SESSION['flash']['old'] = $new;
$_SESSION['flash']['new'] = [];

$_SESSION['csrf'] = bin2hex(openssl_random_pseudo_bytes(16));

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(!isset($_POST['csrf']) || $_POST['csrf'] !== $csrfToken) {
        echo '不正な処理が行われました';
        exit;
    }
    $post = $_POST;
    unset($post['csrf']);
    $_SESSION['flash']['new']['oldInput'] = $post;
}
