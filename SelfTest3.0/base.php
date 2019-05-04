<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT_PATH', __DIR__);
define('ST_PATH', ROOT_PATH . DS . 'ST');

define('ST_EXT', 'st');
define('SCRIPT_EXT', 'php');

/**
 * 异常处理
 */
set_exception_handler(function ($err) {
    $eol = array_key_exists('argc', $_SERVER)? PHP_EOL: '<br />';
    echo 'In file ' . $err ->getFile() . ':' . $err ->getLine() . " throw: {$eol}" . $err ->getMessage() . $eol;
});


/**
 * 自动引入
 */
spl_autoload_register(function ($class_name) {
    $class_name = str_replace('_', DS, $class_name);
    if (!include(ST_PATH . DS . $class_name . '.' . SCRIPT_EXT))
        throw new E("class ${class_name} not found", 404);
}, true, true);

