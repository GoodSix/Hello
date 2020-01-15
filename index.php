<?php
//error_reporting(0);
date_default_timezone_set('PRC');

include __DIR__ . '/ST/base.php';

header('Access-Control-Allow-Origin: *');
// web下只起接口作用
header('Content-Type: application/json');
header('token: ' . token());

$uri = $_SERVER['REQUEST_URI'];
$uri = preg_grep('/^[^\.]\w*$/', explode('/', $uri));

$app = new H_App();

$action = array_shift($uri) ?? 'null';
if (!method_exists($app, $action)) throw new E("The {$action} method cannot be used");
$app ->action = $action;
// 身份认证，参数内为不需要验证身份的方法名
$app ->verify(['search', 'upload_file', 'download']);
$resp = $app->$action(...$uri);
if (!$resp || !is_string($resp)) throw new E('Data type error, please perform on server');
echo $resp;