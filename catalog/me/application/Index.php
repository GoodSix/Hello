<?php
// 全局常量
define('APP_PATH', getcwd());
define('ROOT_PATH', dirname(APP_PATH));
define('LIB_PATH', ROOT_PATH . 'library');
// 类库映射
$class_map = [
    ROOT_PATH . '/application' => 'app',
    ROOT_PATH . '/library' => 'lib',
];

include '../autoload.php';

$app = new \app\App();