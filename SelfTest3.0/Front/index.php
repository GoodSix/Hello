<?php
//error_reporting(0);

include dirname(__DIR__) . '/base.php';

if(!isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && !strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest"){
    die();
}

$uri = $_SERVER['REQUEST_URI'];
$uri = preg_grep('/^[^\.]\w*$/', explode('/', $uri));
