<?php
//error_reporting(0);

include __DIR__ . '/base.php';

if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest"){
    $handler = 'ajax';
}elseif (isset($_SERVER['argc']) && $_SERVER['argc']){
    $handler = 'cgi';
}else {
    $handler = 'web';
}
$handler = 'Handler_' . ucfirst(strtolower($handler));


$handler = new $handler();
$uri = $_SERVER['REQUEST_URI'];
$uri = preg_grep('/^[^\.]\w+$/', explode('/', $uri));
$method = array_shift($uri);
if (!method_exists($handler, $method))
    throw new E("The {$method} method cannot be found in the {$handler} class");

$handler ->$method(...$uri);