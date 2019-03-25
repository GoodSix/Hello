<?php

/**
 * Created by IntelliJ IDEA
 * User:    ccheng
 * Email:   1434389213@qq.com
 * Date:    2019-03-22
 * Time:    11:23:41
 */

namespace Lib\SelfTest;

use lib\SelfTest;

class SelfTest2{

    protected $test;       // 当前对象中的测试题
    public $strict = 10;// 容错度
    private $index;     // 当前位置
    // chapter          : 章节目录
    // catalog          : 当前章节
    // index            : 当前章节中的位置
    // catalog_index    : 每个章节中所有的试题数量，索引随章节目录
    // test_directory   : 被解析的试题位置
    private $success;   // 正确试题
    private $errors;    // 错误试题

    private static $ctest; // 修改试题对象

    /**
     * SelfTest2 constructor.
     * @param array $param
     */
    public function __construct(...$param) {
        $this ->test = $this ->getParseTest(...$param);
        $this ->reset();
        $this ->index['test_directory'] = $param[0];
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
    public function getParseTest(string $file_name, int $rand = 1):array {
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
        reset($test);
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
     * 获取当前的正确回答信息
     * @return array
     */
    public function getSuccess():?array {
        return $this ->success;
    }

    /**
     * 获取当前的错题信息
     * @return array
     */
    public function getErrors():?array {
        return $this ->errors;
    }

    /**
     * 获取剩余试题个数
     * @return int
     */
    public function getRest():int {
        $position = $this ->getPosition();
        $num = $this ->index['chapter_num'][$position['catalog_index']] - $position['index'] - 1;
        for($i = $position['catalog_index'] + 1; $i < count($this ->index['chapter_num']); $i ++) {
            $num += $this ->index['chapter_num'][$i];
        }
        return $num;
    }

    /**
     * 获取当前进度
     * @return array
     */
    public function getPosition():array {
        return [
            'catalog'   => $this ->index['catalog'],
            'catalog_index' => array_search($this ->index['catalog'], $this ->index['chapter']),
            'index'     => $this ->index['index'],
        ];
    }

    /**
     * 返回当前试题索引
     * @return array|null
     */
    public function getIndex():?array {
        return $this ->index;
    }

    /**
     * 设置当前进度
     * @param string $catalog 章节名
     * @param int $index 索引位置
     * @return bool 设置是否成功
     */
    public function setPosition(string $catalog, int $index = 0):bool {
        return in_array($catalog, $this ->index['chapter'])
            && ($this ->index['catalog'] = $catalog)
            && $index > -1
            && ($this ->index['index'] = $index) > -1;
    }

    /**
     * 比较两个字符串的相差度
     * @param string $string1 第一个字符串
     * @param string $string2 第二个字符串
     * @param bool $caps 是否忽略大小写
     * @return float 相差度
     */
    protected function checkString(string $string1, string $string2, bool $caps = true):float {
        $len1 = strlen($string1);
        $len2 = strlen($string2);
        $minlen = min($len1, $len2);
        $index = $diff = 0;
        do {
            if ($caps){
                $string1[$index] = strtolower($string1[$index]);
                $string2[$index] = strtolower($string2[$index]);
            }
            if ($string1[$index] == $string2[$index]) continue;
            else $diff ++;
        }while($index ++ < $minlen - 1 && isset($string2[$index]));
        return (max($len1, $len2) - min($len1, $len2) + $diff) / max($len1, $len2) * 100;
    }

    /**
     * 重置当前进度
     * @return void
     */
    public function reset():void {
        $this ->index = [
            'chapter'   => array_keys($this ->test),
            'catalog'   => key($this ->test),
            'index'     => 0,
        ];
        // $this ->index['catalog'] = $this ->index['chapter'][0];
        // 每个分类下面的试题个数, 下标和chapter一样
        foreach ($this ->index['chapter'] as $value) {
            $this ->index['chapter_num'][] = count($this ->test[$value]);
        }
        return;
    }

    /**
     * TODO:: 不需要大小写要在valid的实参中声明
     * 返回指定字符串和当前试题是否匹配
     * @param string $input 被对比的字符串
     * @param bool $caps 是否忽略大小写
     * @param string $cmp 对比字段，可选function，effect，skill
     * @return float 相似度
     */
    public function valid(string $input, bool $caps = true, string $cmp = 'function'):float {
        $cmp = round($this ->checkString($input, $this ->current()[$cmp], $caps), 2);
        // 题库记录
        if ($cmp < round($this ->strict, 2)){
            $this ->success[] = $this ->current();
            $this ->success = array_unique($this ->success);
        }else {
            $this ->errors[] = $this ->current();
            $this ->errors = array_unique($this ->errors);
        }
        return 100 - $cmp;
    }

    /**
     * 返回上一题信息,如果没有则为空
     * @return array
     */
    public function prev():?array {
        $position = $this ->getPosition();
        if ($this ->index['index'] < 1) {
            return @$this ->index[$this ->index['chapter'][$position['chapter_num']] - 1][$this ->index['chapter_num'][$position['catalog_index'] - 1] - 1];
        }else {
            return @$this ->index[$position['catalog']][$position['index'] - 1];
        }
    }

    /**
     * 返回当前试题信息
     * @return array
     */
    public function current():array {
        return $this ->test[$this ->index['catalog']][$this ->index['index']];
    }

    /**
     * 返回下一题信息,如果没有则为空
     * @return array
     */
    public function next():?array {
        $position = $this ->getPosition();
        if ($this ->index['index'] < $this ->index['chapter_num'][$position['index']] - 1){
            return @$this ->test[$this ->index['catalog']][$this ->index['index'] + 1];
        }elseif(isset($this ->test[$this ->index['chapter'][$position['catalog_index'] + 1]])) {
            return @$this ->test[$this ->index['chapter'][$position['catalog_index'] + 1]][0];
        }
    }

    /**
     * 跳到下一题,返回剩余试题个数
     * @param int $sep 跳跃次数
     * @return int 剩余试题个数
     */
    public function jump(int $sep = 1):int {
        if($rest = $this ->getRest()){
            // 位置向后移动
            $position = $this ->getPosition();
            $this ->index['index'] += $sep;
            if ($this ->index['index'] >= $this ->index['chapter_num'][$position['catalog_index']] - 1) {
                $this ->index['catalog'] = $this ->index['chapter'][$position['catalog_index'] + 1];
                $this ->index['index'] -= $this ->index['chapter_num'][$position['catalog_index'] + 1];
            }
        }
        return $rest;
    }

	/**
	 * 获取ETest实例，对当前试题文件进行修改
	 */
    public function getETest() {
        if (!self::$ctest) self::$ctest = \Lib\SelfTest\ETest::getInstance($this ->index['test_directory']);
        return self::$ctest;
    }
}