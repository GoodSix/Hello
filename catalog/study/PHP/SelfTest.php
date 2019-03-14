<?php
/**
 * User: ccheng
 * Date: 19-3-14
 * Time: 下午3:09
 */

/**
 * Class SelfTest
 * 自测系统，已实现迭代器
 */
class SelfTest implements Iterator{

    private static $_self; // 如果需要扩展，$_self为实体

    protected $file;// 试题位置

    public $test = [];   // 试题内容

    /**
     * SelfTest constructor.
     * 构建测试题目
     *
     * @param String $file 测试路径
     * @param string $mode 文件的打开方式
     */
    public function __construct (String $file, String $mode = 'r') {
        try {
            $this ->file = @fopen($file, $mode);
            if (!$this ->file) throw new Exception('找不到试题文件');
            while(!feof($this ->file)) {
                $fgets = fgets($this ->file);
                $matches = [];
                // 匹配题目
                if (preg_match('/^\|\s(.*?)\s\|\s(.*?)\s\|\s(.*?)\s\|/m', $fgets, $matches)) {
                    // 如果当前是函数分类
                    if (!$matches[count($matches) - 1]) {
                        $this ->test[($matches)[1]] = [];
                    }else {
                        // 向当前分类下添加子函数
                        end($this ->test);
                        array_shift($matches);
                        $this ->test[key($this ->test)][] = $matches;
                    }
                }
            }
            // 删除标题部分
            array_shift($this ->test);
            if (!count($this ->test)) throw new Exception('试题文件解析失败');
        }catch (Exception $e) {
            exit("构造出错，因为{$e ->getMessage()}");
        }
    }

    /**
     * 如果需要自定义考试模式，直接调用此方法可解析试题
     * @param mixed ...$param
     * @return array
     */
    public static function getTest(...$param) {
        if (!self::$_self) self::$_self = new self(...$param);
        return self::$_self ->test;
    }

    public function key() {
    }

    public function current() {
    }

    public function next() {
    }


    public function valid() {
    }

    public function rewind() {
    }

    public function __destruct () {
        if ($this ->file) fclose($this ->file);
    }
}