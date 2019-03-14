<?php
/**
 * User: ccheng
 * Date: 19-3-14
 * Time: 下午3:09
 */

/**
 * Class SelfTest
 * 自测系统，已实现迭代器，命令行下直接遍历该对象即可
 */
class SelfTest implements Iterator{

    private static $_self;  // 如果需要扩展，$_self为实体

    protected $file;        // 试题位置
    public $test = [];      // 试题内容

    private $end;           // 结束位置
    private $iterator;      // 迭代记录
    private $input;         // 检测输入
    private $reduce;        // 成绩汇总

    /**
     * SelfTest constructor.
     * 构建测试题目
     *
     * @param String $file 测试路径
     * @param bool $rand 是否随机试题的顺序
     * @param string $mode 文件的打开方式
     */
    public function __construct (String $file, bool $rand = true, String $mode = 'r') {
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
            if ($this ->file) fclose($this ->file);
            // 删除标题部分
            array_shift($this ->test);
            if (!count($this ->test)) throw new Exception('试题文件解析失败');
            if ($rand) {
                foreach ($this ->test as $k =>$v) {
                    shuffle($this ->test[$k]);
                }
            }
        }catch (Exception $e) {
            exit("构造出错，因为{$e ->getMessage()}" . PHP_EOL);
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

    public function rewind() {
        reset($this ->test);
        $this ->iterator = [key($this ->test), 0];                                // 记录当前位置
        $this ->end = array_keys($this ->test)[count(array_keys($this ->test)) - 1];// 获取最后一个章节位置
    }

    public function valid() {
//        fwrite(STDOUT, str_repeat(PHP_EOL, 100)); // 清屏
        system('clear');
        if ($this ->iterator[0] == $this ->end && $this ->iterator[$this ->end] == count($this ->iterator[$this ->end]) - 1) {
            fwrite(STDOUT, $this ->reduce . PHP_EOL);
        }else {
            fwrite(STDOUT, $this ->input . PHP_EOL);
            $this ->input = null;
            return true;
        }
    }

    public function next() {
        $current = $this ->test[$this ->iterator[0]][$this ->iterator[1]];
        $success = 0;
        similar_text($this ->input, $current[0], $success);
        if (!$this ->input) {
            $this ->input = '弃权';
        }elseif ($this ->input == $current[0]) {
            $this ->iterator[1] ++; // 回答正确n(*≧▽≦*)n， 进入下一道试题
            if ($this ->iterator[1] >= count($this ->test[$this ->iterator[0]]) - 1) {
                next($this ->test);
                $this ->iterator[0] = key($this ->test);
            }
            $this ->input = "\t上次回答：函数{$current[0]}：{$current[2]}" . PHP_EOL;
        }else {
            $this ->input = '回答错误，该函数的说明为：' . $current[2] . PHP_EOL . "\t" . '您的答案与正确答案的相似度为' . round($success, 2) . '，请再次回答';
        }
    }

    public function key() {
        return key($this ->test);
    }

    public function current() {
        fwrite(STDOUT, '在' . $this ->iterator[0] . '中，' . $this ->test[$this ->iterator[0]][$this ->iterator[1]][1] . '的函数为：' . PHP_EOL);
        fscanf(STDIN, '%s', $this ->input); // 接收输入
    }
}

foreach(new SelfTest('./function.md') as $v) {}