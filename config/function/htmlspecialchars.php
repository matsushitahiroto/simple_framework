<?php

if (!function_exists('imagecreatetruecolor')) {
    echo 'GD not installed';
    exit;
}

function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, 'utf-8');
}
