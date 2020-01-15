<?php
use App\Request\Session;
use App\Request\Request;

/**
 * 表示
 *
 * @param mixed $value
 * @return void
 */
function d($value) {
    var_dump($value);
}
/**
 * 表示処理停止
 *
 * @param mixed $value
 * @return void
 */
function dd($value) {
    var_dump($value);
    die;
}
/**
 * session取得
 */
function session() {
    return new Session();
}

/**
 * 直前のデータを取得
 *
 * @param string $name
 * @return string
 */
function old(string $name) {
    $request = new Request();
    return $request->session()->oldInput($name);
}

/**
 * エスケープ
 *
 * @param string $s
 * @return string
 */
function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, 'utf-8');
}
