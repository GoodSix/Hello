<?php
/***
 *_______________#########_______________________
 *______________############_____________________
 *______________#############____________________
 *_____________##__###########___________________
 *____________###__######_#####__________________
 *____________###_#######___####_________________
 *___________###__##########_####________________
 *__________####__###########_####_______________
 *________#####___###########__#####_____________
 *_______######___###_########___#####___________
 *_______#####___###___########___######_________
 *______######___###__###########___######_______
 *_____######___####_##############__######______
 *____#######__#####################_#######_____
 *____#######__##############################____
 *___#######__######_#################_#######___
 *___#######__######_######_#########___######___
 *___#######____##__######___######_____######___
 *___#######________######____#####_____#####____
 *____######________#####_____#####_____####_____
 *_____#####________####______#####_____###______
 *______#####______;###________###______#________
 *________##_______####________###_______________
 *_________#______####_________####_______________
 */

// 全局常量
define('APP_PATH', getcwd());
define('ROOT_PATH', dirname(APP_PATH));
define('LIB_PATH', ROOT_PATH . '/library');
define('CC_PATH', ROOT_PATH . '/ccheng');
define('GIT_PATH', dirname(dirname(ROOT_PATH)));

// 自动加载助手方法：非惰性加载
$functions = [
    CC_PATH . '/helper'
];

// 类库映射
$class_map = [
    ROOT_PATH . '/application'  => 'App',
    ROOT_PATH . '/ccheng'       => 'C',
    ROOT_PATH . '/library'      => 'Lib',
];
//
include ROOT_PATH . '/ccheng/autoload.php';

$app = new \C\App();
$app ->start();

$test_list = \Lib\SelfTest\SelfTest2::getList(GIT_PATH);

$st2 = new \Lib\SelfTest\SelfTest2($test_list[5]['path'], 0);
$ctest = $st2 ->getETest();

var_dump($ctest ->add('数组函数1', '这是我添加的', '这是说明', '这是介绍'));