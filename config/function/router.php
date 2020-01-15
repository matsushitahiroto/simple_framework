<?php
$request = new App\Request\Request();
$path = empty($_SERVER['PATH_INFO']) ? '/' : implode('/', explode('/', $_SERVER['PATH_INFO']));
$route = require_once('../config/route.php');

if (!isset($route[$path])) {
    $error = 'ページがありません';
    include(ERROR_PATH . '404.php');
    exit;
}
if (!isset($route[$path][$_SERVER['REQUEST_METHOD']])) {
    $error = '想定していないリクエストです';
    include(ERROR_PATH . '404.php');
    exit;
}

$target = $route[$path][$_SERVER['REQUEST_METHOD']];

$targetClass = CONTROLLER_PATH . $target[0];
$targetMethod = $target[1];

try {
    $app = new $targetClass();
    $app->$targetMethod($request);
    exit;
} catch (App\Exception\ValidationException $e) {
    session()->setErrors($e->getErrors());
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
} catch (App\Exception\MethodNotAllowedException $e) {
    $error = $e->getMessage() ?: '存在しないメソッドへのアクセスがありました';
    include(ERROR_PATH . '405.php');
    exit;
} catch (\Exception $e) {
    $error = $e->getMessage() ?: '不明なエラー';
    include(ERROR_PATH . '500.php');
    exit;
}
