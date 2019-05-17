<?php
//error_reporting(0);

include __DIR__ . '/base.php';

if (isset($argc)) {

}else {
    // web下之起接口作用
    header('Content-Type: application/json');
    header('token: ' . token());
    if (!isset(getallheaders()['token'])
        || empty(getallheaders()['token'])
        || !check_token(getallheaders()['token'])
    ) {
        echo resp('给我滚犊子', null, 1005);
        die;
    }

    $uri = $_SERVER['REQUEST_URI'];
    $uri = preg_grep('/^[^\.]\w*$/', explode('/', $uri));

    $app = new H_App();

    $action = array_shift($uri) ?? 'null';
    if (!method_exists($app, $action)) throw new E("The {$action} method cannot be used");
    $resp = $app ->$action(...$uri);
    if (!$resp || !is_string($resp)) throw new E('Data type error, please perform on server');
    echo $resp;
}