<?php
/**
 * User: ccheng
 * Date: 19-3-14
 * Time: 下午3:09
 */

/**
 * Class SelfTest：跳舞的指针
 * 自测系统，已实现迭代器，命令行下直接遍历该对象即可
 */

namespace lib;

class SelfTest implements Iterator{

    private static $_self;  // 如果需要扩展，$_self为实体

    protected $file;        // 试题位置
    protected $test = [];      // 试题内容

    private $end;           // 结束位置
    private $iterator;      // 迭代记录
    private $input;         // 检测输入
    private $reduce = [
        'success'       => 0,   // 正确个数
        'error'         => 0,   // 错误个数
        'jump'          => 0,   // 跳过个数
        'num'           => 0,   // 已答个数
        'remnant'       => 0,   // 剩余个数
        's'             => 0,   // 正确率(所有)
    ];                      // 成绩汇总
    private $err = [];      // 错题统计
    private $_err;          // 当前错题

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
            if ($rand) { // 顺序随机打乱
                foreach ($this ->test as $k =>$v) {
                    shuffle($this ->test[$k]);
                }
                $temp = [];
                foreach ($this ->test as $k =>$v) {
                    $temp[] = [$k =>$v];
                }
                shuffle($temp);
                $this ->test = null;
                foreach ($temp as $v) {
                    $this ->test[key($v)] = current($v);
                }
            }
            foreach ($this as $v) {}
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

    public function fliter() {
        $fliter = null;
        foreach (array_keys($this ->test) as $k =>$v) {
            $fliter .= "{$k}. {$v} ";
        }
        $fliter = trim($fliter);
        fwrite(STDOUT, "当前有：{$fliter}，请按照位置筛选，为空则为全部(多个使用\",\"隔开)" . PHP_EOL);
        $fliter = null;
        fscanf(STDIN, '%s', $fliter);
        if (($fliter = trim($fliter)) !== ''){
            $fliter = explode(',', trim($fliter, ','));
            $temp = [];
            foreach($this ->test as $k =>$v) {
                $temp[] = [$k =>$v];
            }
            // 获取差集，删除，
            $fliter = array_diff(array_keys($temp), $fliter);
            if (count($fliter) != count($temp)) {
                foreach ($fliter as $d) {
                    unset($temp[$d]);
                }
            }
            $this ->test = null;
            foreach($temp as $v) {
                $this ->test[key($v)] = current($v);
            }
        }
    }

    public function rewind() {
        $this ->fliter();

        reset($this ->test); // 重置当前位置
        $this ->iterator = [key($this ->test), 0];                                // 记录当前位置
        $this ->end = array_keys($this ->test)[count(array_keys($this ->test)) - 1];// 获取最后一个章节位置
        $this ->reduce['remnant'] = array_reduce($this ->test, function ($carry, $item) { // 汇总所有个数
            return $carry + count($item);
        }, -1);
    }

    public function valid() {
        // 清屏
        if (!isset($_SERVER))                           fscanf(STDOUT, $this ->output);
        elseif (!array_key_exists('SHELL', $_SERVER))   throw new Exception('无法在非shell环境下运行，如需扩展请调用getTest()生成试题');
        else                                            system(strtolower(PHP_OS) == 'linux'?'clear':'cls');

        fwrite(STDOUT, "当前分类为:{$this ->iterator[0]}\t正确:{$this ->reduce['success']}个\t错误:{$this ->reduce['error']}个\t跳过:{$this ->reduce['jump']}次\t已答:{$this ->reduce['num']}个\t剩余:{$this ->reduce['remnant']}个\t正确率:{$this ->reduce['s']}%" . PHP_EOL);
        if ($this ->iterator[0] == $this ->end && $this ->iterator[1] >= count($this ->test[$this ->iterator[0]]) - 1) {
            return false;
        }else {
            fwrite(STDOUT, wordwrap($this ->input ?? __CLASS__) . PHP_EOL);
            $this ->input = null;
            return true;
        }
    }

    public function next() {
        $current = $this ->test[$this ->iterator[0]][$this ->iterator[1]];
        $success = 0;
        similar_text($this ->input, $current[0], $success);
        if (!$this ->input) { // 跳过
            if ($this ->_err != $current[0]) $this ->reduce['jump'] ++;
            $this ->_err = $current[0];
            $this ->input = "跳过:{$current[0]}" . PHP_EOL;
            // 错题记录
            $this ->err [] = "{$current[0]}：{$current[2]}(跳过)";
        }elseif ($this ->input == $current[0]) {
            $this ->iterator[1] ++; // 回答正确n(*≧▽≦*)n， 进入下一道试题
            if ($this ->iterator[1] >= count($this ->test[$this ->iterator[0]]) - 1) {
                next($this ->test);
                $this ->iterator[0] = key($this ->test);
            }
            // 正确个数记录，如果该题被标记为错题则不增加正确个数
            if ($this ->_err != $current[0]) $this ->reduce['success'] ++;
            // 已答个数
            $this ->reduce['num'] ++;
            // 剩余个数记录
            $this ->reduce['remnant'] --;
            $this ->input = "{$current[0]}：{$current[2]}" . PHP_EOL;
        }else {
            // 错误个数记录
            if ($this ->_err != $current[0]) $this ->reduce['error'] ++;
            $this ->_err = $current[0];
            // 错题库记录
            $this ->err [] = "{$current[0]}：{$current[2]}";
            $this ->input = '回答错误，该函数的说明为：' . $current[2] . PHP_EOL . "\t" . '您的答案与正确答案的相似度为' . round($success, 2) . '，请再次回答';
        }
        // 正确率，保留两位小数
        $this ->reduce['s'] = round($this ->reduce['success'] / $this ->reduce['num'] * 100, 2);
    }

    public function key() {
        return key($this ->test);
    }

    public function current() {
        // fwrite(STDOUT, '在' . $this ->iterator[0] . '中，' . $this ->test[$this ->iterator[0]][$this ->iterator[1]][1] . '的函数为：' . PHP_EOL);
        $current = @$this ->test[$this ->iterator[0]][$this ->iterator[1]][1];
        if ($current)
            fwrite(STDOUT,  $current. '的函数为：' . PHP_EOL);
        else {
            $this ->err = implode(PHP_EOL, array_unique($this ->err));
            fwrite(STDOUT, '错题：' . PHP_EOL . $this ->err . PHP_EOL);
            exit();
        }
        fscanf(STDIN, '%s', $this ->input); // 接收输入
    }
}
new SelfTest('./function.md');