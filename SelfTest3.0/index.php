<?php
//error_reporting(0);

include __DIR__ . '/ST/base.php';

if (isset($argc)) {

} else if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') || isset($_SERVER['HTTP_TOKEN'])) {
    header('Access-Control-Allow-Origin: *');
    // web下只起接口作用
    header('Content-Type: application/json');
    header('token: ' . token());
    $rt = $_SERVER['HTTP_TOKEN'] ?? null;
    if (!isset($rt)
        || empty($rt)
        || !checkToken($rt)
    ) {
        echo resp('身份验证失败', null, 1005);
        die;
    }

    $uri = $_SERVER['REQUEST_URI'];
    $uri = preg_grep('/^[^\.]\w*$/', explode('/', $uri));

    $app = new H_App();

    $action = array_shift($uri) ?? 'null';
    if (!method_exists($app, $action)) throw new E("The {$action} method cannot be used");
    $resp = $app->$action(...$uri);
    if (!$resp || !is_string($resp)) throw new E('Data type error, please perform on server');
    echo $resp;
} else {
    if (isMobile()) header('location: /index.html');
    else header('location: /pc.html');
}