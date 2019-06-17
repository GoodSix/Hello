<?php


class TestObj extends Parse{

    private $title;
    private $catalog;
    private $st;

    /**
     * 优化Parse的重复操作
     * TestObj constructor.
     * @param string $st
     * @throws E
     */
    public function __construct(string $st) {
        parent::__construct($st);
        $this ->title = parent::getTitle();
        $this ->catalog = parent::getCatalog();
        $this ->st = parent::getSt();
    }

    /**
     * 获取标题
     * @return string
     */
    public function getTitle() {
        return $this ->title;
    }

    /**
     * 获取分类信息，或指定分类的信息
     * @param null $catalog
     * @return array|null
     */
    public function getCatalog($catalog = null) {
        if ($catalog){
            $temp = array_column($this ->catalog, 'name');
            if (($index = array_search($catalog, $temp)) === false)
                return null;
            return $this ->catalog[$index];
        }else
            return $this ->catalog;
    }

    /**
     * 解析ST文件
     * @param null $type 解析题目类型，1为文本，2为选择题，否则随机
     * @param null $index 获取指定下标处的数据, 为空表示获取所有数据
     * @return array
     */
    public function getSt($type = null, $index = null) {
        switch ($type) {
            case 1:
                $type = ['text'];
                break;
            case 2:
                $type = ['radio', 'radio', 'radio', 'radio', 'checkbox']; // 降低多选题几率，多选题中相关联提问几率会更低
                break;
            default:
                $type = ['text', 'radio', 'checkbox'];
        }
        if ($index !== null) {
            return $this->parseIssue($this ->st[$index] ?? [], $type[!shuffle($type)]);
        }else{
            shuffle($this ->st);
            return array_map(function ($item) use(&$type) {
                return $this ->parseIssue($item, $type[!shuffle($type)]);
            }, $this ->st);
        }
    }

    /**
     *
     * @param $st
     * @param $type
     * @return null
     */
    private function parseIssue($st, $type) {
        if (!is_array($st)) {
            return null;
        }else if (!array_key_exists('title', $st) || !array_key_exists('declare', $st) || !array_key_exists('catalog', $st)) {
            // 不符合规范的内容直接跳过
            return $st;
        }

        $issue = [];

        // halt($st);
        // 组合问题
        $issue['issue'] = $st['declare'];
        /*
         switch (mt_rand(0, 1)) {
            case 0:
                $issue['issue'] = $st['declare']
                    . (array_key_exists('param', $st)? ', 有' . count($st['param']) . '个常用参数': null);
                break;
            case 1:
                $issue['issue'] = $link3[shuffle($link3)]
                    . $st['declare'];
                break;
            case 2:
                break;
            default:
         }
        */

        // 回答题
        $text = function () use($st, &$issue) {
            $issue['item'] = null;
            $issue['answer'] = $st['title'];
            $issue['type'] = 'text';
        };

        // 单选题
        $radio = function () use($st, &$issue) {
            $item = [];
            $issue['answer'] = $st['title'];
            // 10%几率是混肴，如果数量过少几率为100%
            // 只有在数量过少的时候问题是混肴的，如果有多选的机会那么答案也是混肴的
            // TODO: 多选题目有点奇怪哦
            if (count($this ->st) < 10 /* || !mt_rand(0,9) */ ) {
                $rand = array_merge(range('a', 'z'), range('a', 'z'), range('A', 'Z'), []);
                for($i = 0; $i < mt_rand(4, 5); $i ++) {
                    $in = str_split_unicode($issue['answer']);
                    // 根据$ran的内容随机替换
                    $keys = array_rand($in, mt_rand(1, max(floor((count($in) - 1) / 3), 1)));
                    if (!is_array($keys)) $keys = [$keys];
                    foreach($keys as $key =>$value) {
                        if (trim($in[$value]))
                            $in[$key] = $rand[shuffle($rand)];
                        else continue;
                    }
                    $item[] = implode('', $in);
                }
            }else {
                $item = array_rand($this ->st, mt_rand(4, 6));
                foreach ($item as $k =>$v) {
                    $item[$k] = $this ->st[$v]['title'];
                }
            }
            $item[array_rand($item)] = $issue['answer']; // 将正确答案随机插入
            $item = array_unique($item);
            $issue['item'] = $item;
            $issue['type'] = 'radio';
        };

        // 多选题
        $checkbox = function () use($st, &$issue) {
            $issue['type'] = 'checkbox';
            $rand = mt_rand(0, 15); // 将提问相关联的问题的几率降低，因为貌似有些？？别扭？？？
            // 这里才是实际起作用的地方，不行的话就转到单选类型了
            // 为毛这样写？？因为我喜欢
            $parse = function ($type) use($st, &$issue) {
                $rand = array_merge(range('a', 'z'), range('a', 'z'), range('A', 'Z'), []);
                // 这里就是复制上面的，就是重复代码
                $checkbox = array_rand($st[$type], mt_rand(1, max(floor(count($st[$type]) - 1), 1)));
                if (!is_array($checkbox)) $checkbox = [$checkbox]; // 随机取出，不是数组则转换为数组
                $item = [];
                $answer = [];
                foreach ($checkbox as $key =>$value) {
                    if (isset($st[$type][$value]['param']))
                        $answer[] = $st[$type][$value]['param']; // 答案
                    else $answer[] = $st[$type][$value];

                    $in = str_split_unicode($answer[count($answer) - 1]);
                    // 根据$ran的内容随机替换
                    $keys = array_rand($in, mt_rand(1, max(floor((count($in) - 1) / 3), 1)));
                    if (!is_array($keys)) $keys = [$keys];
                    foreach($keys as $key =>$value) {
                        if (trim($in[$value]))
                            $in[$key] = $rand[shuffle($rand)];
                        else continue;
                    }
                    $in = array_unique($in);
                    $item[] = implode('', $in);
                }
                $item = array_merge($item, $answer);
                shuffle($item);
                $item = array_unique($item);
                $issue['item'] = $item;
                $issue['answer'] = $answer;
            };
            if ($rand && isset($st['param'])) {
                // 解析param
                $link = ['请选择它的常用参数', '请问它的常用参数有', '它的常用参数有', '常用的参数是', '常用参数是'];
                $issue['issue'] .= ', ' . $link[shuffle($link)] . ' : '; // 提示回答参数
                $parse('param');
            }else if (isset($st['link'])) {
                // 解析link
                $link = ['和它一起经常一起用的有', '和它作用相似的有', '和它类似的有'];
                $issue['issue'] .= ', ' . $link[shuffle($link)] . ' : '; // 提示回答关联
                $parse('link');
            }else if (isset($st['param'])) {
                $link = ['请选择它的常用参数', '请问它的常用参数有', '它的常用参数有', '常用的参数是', '常用参数是'];
                $issue['issue'] .= ', ' . $link[shuffle($link)] . ' : '; // 提示回答参数
                // 解析param
                $parse('param');
            }else {
                // 这里连改动都没有，Ctrl + c 、Ctrl + v
                $item = [];
                $issue['answer'] = $st['title'];
                $rand = array_merge(range('a', 'z'), range('a', 'z'), range('A', 'Z'), []);
                for($i = 0; $i < mt_rand(4, 5); $i ++) {
                    $in = str_split_unicode($issue['answer']);
                    // 根据$ran的内容随机替换
                    $keys = array_rand($in, mt_rand(1, max(floor((count($in) - 1) / 3), 1)));
                    if (!is_array($keys)) $keys = [$keys];
                    foreach($keys as $key =>$value) {
                        if (trim($in[$value]))
                            $in[$key] = $rand[shuffle($rand)];
                        else continue;
                    }
                    // $in = array_unique($in);
                    $item[] = implode('', $in);
                }
                $item[array_rand($item)] = $issue['answer'];
                $item = array_unique($item);
                $issue['item'] = $item;
                $issue['type'] = 'radio';
            }
        };

        $$type();
        $st['issue'] = [
            'issue'  => $issue['issue'] ?? '无法解析',     // 题目
            'type'   => $issue['type'] ?? $type,                             // 类型
            'item'   => $issue['item'] ?? '无法解析',       // 解析出的问题
            'answer' => $issue['answer'] ?? '无法解析',     // 答案
        ];
        // halt($st);
        return $st;
    }

    /**
     * 获取指定分类下的数据
     * @param null $catalog 为null是为了兼容web开发，如果实际为null则获取不到数据
     * @return array
     */
    public function getStByCatalog($catalog = null) {
        $arr = [];
        foreach ($this ->st as $k =>$item) {
            if ($item['catalog'] == $catalog)
                $arr[] = $this ->st[$k];
        }
        return $arr;
    }

    /**
     * debug打印的数据
     * @return array|false|string
     */
    public function __debugInfo() {
        return $this ->st;
    }
}