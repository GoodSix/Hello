<?php


class Parse {

    private $st = 'ccheng';

    public function __construct(string $st) {
        if (is_file($st) && is_readable($st)) $st = file_get_contents($st);
        elseif (is_dir($st) && is_readable($st)) $st = file_get_contents(LoadFile::getList($st)[0]);
        elseif (strpos($st, PHP_EOL) === false) throw new E('别他妈扯了，你他妈的就是想调戏我了');
        $this ->st = $st;
    }

    /**
     * 获取标题
     * @return string
     */
    public function getTitle() {
        $title = [];
        $arr = explode(PHP_EOL, $this->st);
        for ($i = 0; $i < 10; $i++) {
            if (preg_match('/^\~\s(.*?)\s\~$/', trim($arr[$i]), $title))
                return end($title);
        }
    }

    /**
     * 获取分类信息
     */
    public function getCatalog() {
        $catalog = [];
        preg_match_all('/^\#+\s\w*/miu', $this->st, $catalog);
        $catalogs = [];
        foreach (end($catalog) as $value) {
            $catalogs[]['name'] = substr($value, stripos($value, ' ') + 1);
            $last_key = count($catalogs) - 1;
            $catalogs[$last_key]['level'] = substr_count($value, '#');
            $catalogs[$last_key]['pid'] = $catalogs[$last_key]['level'] == 1 ?true: (function () use($catalogs, $catalog, $last_key){
                $temp_catalog = $catalogs;
                arsort($temp_catalog);
                $current_level = $catalogs[$last_key]['level'];
                $v = 'not found name';
                foreach ($temp_catalog as $k =>$v) {
                    if ($v['level'] == $current_level - 1) return $k;
                }
                $cl = $current_level - 1;
                throw new E("Parse error: {$v['name']} is a {$current_level} level category, but the parent category is not a {$cl} level category");
            })();
        }
        return $catalogs;
    }

    public function getSt() {
        $st = [];
        $arr = explode(PHP_EOL, $this ->st);
        $last_key = 0;
        while(($item = next($arr)) !== false) {
            $temp = '';
            if (preg_match('/^[^~#@`](\s{3}|\t)\S.*/', $item, $temp)) { // 匹配标题
                if ($temp = trim(reset($temp))) {
                    $st[$last_key]['title'] = $temp;
                    $last_key = count($st);
                }
            }elseif (preg_match('/^[^#@`]\s{7}\S(.*)\s?(.*)\>\s(.*?)\S$/', $item, $temp)) { // 匹配参数
                if ($temp = explode(' ', trim(reset($temp)), 3)){
                    $temp[1] = str_replace('>', '', $temp[1]);
                    $st[$last_key - 1]['param'][]['param'] = $temp[0];
                    $lk = count($st[$last_key - 1]['param']) - 1;
                    $st[$last_key - 1]['param'][$lk]['type'] = $temp[1];
                    $st[$last_key - 1]['param'][$lk]['declare'] = $temp[2];
                }
            }elseif (preg_match('/^[^#@`]\s{7}(.*)\<\s(.*)$/', $item, $temp)) { // 匹配返回值
                $st[$last_key - 1]['return']['type'] = trim($temp[1]);
                $st[$last_key - 1]['return']['declare'] = trim($temp[2]);
            }elseif (preg_match('/^[^#@`]\s{7}\+\s(.*)/', $item, $temp)) { // 匹配介绍
                if (!array_key_exists('declare', $st[$last_key - 1])) $st[$last_key - 1]['declare'] = '';
                $eol = $_SERVER['argc']? PHP_EOL: '<br />';
                $st[$last_key - 1]['declare'] = trim($st[$last_key - 1]['declare']) . $eol . trim($temp[1]);
            }elseif (preg_match('/^[^#@`]\s{7}\@\s(.*)$/', $item, $temp)) { // 匹配关联
                $temp[1] = str_ireplace('，', ',', $temp[1]);
                if ($link = explode(',', trim($temp[1])))
                    foreach ($link as $key =>$item) {
                        $link[$key] = trim($item);
                    }
                    $st[$last_key - 1]['link'] = $link;
            }elseif (preg_match('/^[^#@`]\s{7}```$/', $item, $temp)) { // 匹配代码块
                if (!array_key_exists('code', $st[$last_key - 1])) $st[$last_key - 1]['code'] = '';
                $item = next($arr);
                while (!preg_match('/^[^#@`]\s{7}```$/', $item)) {
                    if (strpos(($code = next($arr)), '```') === false) $st[$last_key - 1]['code'] .= $code;
                    $item = current($arr);
                }
            }
        }
        return $st;
    }

    public function __debugInfo() {
        return is_array($this ->st)?$this ->st: [
            '嘿，这是什么时候写的来着，忘记了？',
            '不知道现在的你是出于什么目的，看到了这段话',
            '你当初的设计是',
            '不让直接使用这个类',
            'TestObj有继承了，重写了这边的方法',
            '嗯，能看见最好，(●\'◡\'●)',
        ];
    }
}