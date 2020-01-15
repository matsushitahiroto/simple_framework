<?php

/**
 * 指定されたパスへリダイレクト
 *
 * @param string $path
 * @return void
 */
function redirect(string $path, array $params = []) {
    foreach ($params as $key => $value) {
        session()->flash($key, $value);
    }
    header('Location: ' . SITE_URL . $path);
}

/**
 * 指定された名前の画面を描画
 *
 * @param string $fileName
 * @param array $params
 * @return void
 */
function view(string $fileName, array $params = []) {
    foreach ($params as $key => $value) {
        $$key = $value;
    }
    $errors = session()->errors();
    session()->forget(['oldInput', 'errors']);
    $csrf = '<input type="hidden" name="csrf" value="' . session()->get('csrf') . '">';
    include(VIEWS_PATH . $fileName . '.php');
}
