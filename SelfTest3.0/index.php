<?php
//error_reporting(0);

include __DIR__ . '/base.php';

if (isset($argc)) {

}else {
    $uri = $_SERVER['REQUEST_URI'];
    $uri = preg_grep('/^[^\.]\w*$/', explode('/', $uri));

    $app = new H_App();

    $action = array_shift($uri);
    if (!method_exists($app, $action)) throw new E("The {$action} method cannot be used");
    $resp = $app ->$action(...$uri);
    if (!$resp || !is_string($resp)) throw new E('Data type error, please perform on server');
    echo $resp;
}