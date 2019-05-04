<?php
//error_reporting(0);

include __DIR__ . '/base.php';
$test = new TestObj('.');
var_dump($test ->getSt(1));