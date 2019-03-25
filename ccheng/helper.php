<?php
/**
 * Created by IntelliJ IDEA.
 * User: ccheng
 * Date: 19-3-22
 * Time: 下午4:19
 */
if (!function_exists('dd')) {
	/**
	 * 打印并停止当前脚本
	 * @param ...$param 要打印的内容
	 */
    function dd(...$params) {
        $parent = debug_backtrace()[0];
        echo "在{$parent['file']}:{$parent['line']}中输出如下：" . PHP_EOL;
        foreach ($params as $param) {
            print_r($param);
            echo PHP_EOL;
		}
		exit();
    }
}

if (!function_exists('array_dimension')) {
	/**
	 * 获取数组维度, 注意:该函数只会判断数组第一个位置的值
	 * @param array $arr 对该数组进行维度获取
	 * @return int 该数组的维度
	 */
	function array_dimension(array $arr):int {
		$dimension = 1;
		while(is_array($value = current($arr))) {
			$arr = $value;
			$dimension ++;
		}
		return $dimension;
	}
}