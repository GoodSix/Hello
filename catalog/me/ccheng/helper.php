<?php
/**
 * Created by IntelliJ IDEA.
 * User: ccheng
 * Date: 19-3-22
 * Time: 下午4:19
 */
if (!function_exists('dd')) {
    function dd(...$params) {
        $parent = debug_backtrace()[0];
        echo "在{$parent['file']}:{$parent['line']}中输出如下：" . PHP_EOL;
        foreach ($params as $param) {
            print_r($param);
            echo PHP_EOL;
        }
        die();
    }
}