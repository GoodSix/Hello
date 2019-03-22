<?php
// 全局常量
define('APP_PATH', getcwd());
define('ROOT_PATH', dirname(APP_PATH));
define('LIB_PATH', ROOT_PATH . 'library');

// 类库映射
$class_map = [
    ROOT_PATH . '/application'  => 'App',
    ROOT_PATH . '/ccheng'       => 'C',
    ROOT_PATH . '/library'      => 'Lib',
];
//
include ROOT_PATH . '/ccheng/autoload.php';

$app = new \C\App();