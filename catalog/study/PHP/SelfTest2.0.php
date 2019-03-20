<?php

class SelfTest{

    protected $test; // 当前对象中的测试题
    protected $strict; // 匹配答案的精准度,最低50%,当小于95%的时候忽略大小写

    public function __construct(...$param) {
        $this ->test = self::getParseTest(...$param);
        var_dump($this ->asciiCheckString('woshishabi', 'skwucducak'));
    }

    /**
     * 从指定文件夹下搜索试题文件，前10行正则匹配标题：/^#\s(.*?)\s#$/
     * @param string $directory 起始查找的目录
     * @param bool $read 取消搜索隐藏目录
     * @param string $extension 试题文件后缀
     * @param $list
     * @return array ['catalog' =>测试题分类, 'path' =>文件路径]
     * @throws Exception 无权限/非目录/不存在
     */
    public static function getList(string $directory, bool $read = true, string $extension = 'md', array &$list = []):array {
        if (file_exists($directory) && is_readable($directory)) {
            $directory = rtrim($directory, DIRECTORY_SEPARATOR);
            $opendir = opendir($directory);
            while($readdir = readdir($opendir)) {
                if ($readdir == '.' || $readdir == '..' || $read && preg_match('/^\./', $readdir)) continue;
                $path = $directory . DIRECTORY_SEPARATOR . $readdir;
                if (is_file($path) && is_readable($path) && pathinfo($path, PATHINFO_EXTENSION) == $extension) {
                    $fopen = fopen($path, 'r');
                    for($i = 0; $i < 10; $i ++) {
                        $matches = [];
                        preg_match('/^#\s(.*?)\s#$/', fgets($fopen), $matches);
                        if (count($matches) > 0) {
                            $list[] = [
                                'catalog'   => end($matches),
                                'path'      => realpath($path),
                            ];
                        }
                    }
                }elseif(is_dir($path)) self::getList($path, $read, $extension, $list);
            }
            closedir($opendir);
        }else {
            throw new Exception('无法读取目录：' . $directory);
        }
        return $list;
    }

    /**
     * 解析试题文件
     * @param string $file_name 试题文件路径
     * @param int $rand 打乱顺序，强度:0不打乱，1子顺序打乱，2目录顺序也会随机
     * @return array 解析后的试题
     * @throws Exception 解析错误
     */
    public static function getParseTest(string $file_name, int $rand = 1):array {
        $file = @fopen($file_name, 'r');
        if (!$file) throw new Exception('找不到试题文件');
        $test = [];
        while(!feof($file)) {
            $fgets = fgets($file);
            $matches = []; // 匹配题目
            if (preg_match('/^\|\s(.*?)\s\|\s(.*?)\s\|\s(.*?)\s\|/', $fgets, $matches)) {
                end($test);
                if ($matches[count($matches) - 1] && end($matches) && key($test)) {
                    $test[key($test)][] = [
                        'function'  => $matches[1],
                        'effect'    => $matches[2],
                        'skill'     => $matches[3],
                    ];
                }elseif(!end($matches)) { // 如果最后一个内容为空，那么这一行就是新分类
                    $test[$matches[1]] = [];
                }
            }
        }
        if (!count($test)) throw new Exception('在指定的试题文件中没有解析到试题内容');
        if ($rand) {
            // 打乱子顺序
            foreach($test as $key =>$value) {
                shuffle($test[$key]);
            }
            if ($rand > 1) { // 目录顺序打乱
                $temp = [];
                foreach($test as $key =>$value) {
                    $temp[] = [$key =>$value];
                }
                shuffle($temp);
                $test = [];
                foreach($temp as $value) {
                    $test[key($value)] = current($value);
                }
                unset($temp);
            }
        }
        return $test;
    }

    /**
     * 使用ascii码偏移量比较两个字符串的差，以百分比方式返回
     * @param string $string1 第一个字符串
     * @param string $string2 第二个字符串
     * @param bool $caps 是否区分大小写
     * @return float 差
     */
    protected function asciiCheckString(string $string1, string $string2, bool $caps = false):float {
        $len1 = strlen($string1);
        $len2 = strlen($string2);
        $maxlen = max($len1, $len2);

    }

    public function valid():bool {

    }
    public function prev():array {

    }
    public function current():array {

    }
    public function next():bool {

    }
}
$st = new SelfTest('./function.md');
//var_dump($st);
//var_dump(SelfTest::getList('../../../'));