<?php

// 项目配置
define('DS', DIRECTORY_SEPARATOR);
define('ROOT_PATH', dirname(__DIR__));
define('ST_PATH', ROOT_PATH . DS . 'ST');
define('RUNTIME_PATH', ROOT_PATH . DS . 'runtime');
if (!file_exists(RUNTIME_PATH)) mkdir(RUNTIME_PATH, 0777, false);
// 兼容配置
define('ST_EXT', 'txt');
define('SCRIPT_EXT', 'class.php');
define('WEB_EOL', '<br />');    // web下详情的换行方式

// 异常处理
set_exception_handler(function ($err) {
    if (isset($argc)) {
        $eol = PHP_EOL;
        echo 'In file ' . $err ->getFile() . ':' . $err ->getLine() . " throw: {$eol}" . $err ->getMessage() . $eol;
    }else {
        echo json([
            'err'  => 1002,
            'msg'   =>'In file ' . $err ->getFile() . ':' . $err ->getLine() . " throw: " . $err ->getMessage()
        ]);
    }
});

include ST_PATH . '/helper.php';

// 自动引入
spl_autoload_register(function ($class_name) {
    $class_name = str_replace('_', DS, $class_name);
    if (!include(ST_PATH . DS . $class_name . '.' . SCRIPT_EXT))
        throw new E("class ${class_name} not found", 404);
}, true, true);
