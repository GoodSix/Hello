<?php
/**
 * Created by IntelliJ IDEA.
 * User: ccheng
 * Date: 19-3-22
 * Time: 下午8:40
 */
namespace Lib\SelfTest;

class CTest{
    private static $_self;

    private $directory;     // 源文件路径
    private $file;          // 文件源内容


    private function __construct(string $directory) {
        $this ->directory = $directory;
        $this ->file = file($this ->directory);
    }

    public static function getInstance(...$params) {
        if (!self::$_self) self::$_self = new self(...$params);
        return self::$_self;
    }

    public function add($catalog, string $test = null, $s) {

    }

    /**
     * 删除指定的条目
     * @param $function 函数名
     */
    public function delete($function) {
        foreach ($this ->file as $key =>$line) {
            if (count($f = explode('|', $line)) == 5) {
                if ($function == trim($f[1])) {
                    unset($this ->file[$key]);
                    break;
                }
            }
        }
    }


    public function edit() {

    }

    public function __destruct() {
        // 将整理过的内容写入到源文件
        file_put_contents($this ->directory . '.bak', implode('', $this ->file));
    }
}