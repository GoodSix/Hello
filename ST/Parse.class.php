<?php


abstract class Parse {

    private $st = 'ccheng';
    private $file_md5 = '';
    protected $file_name = '';

    public function __construct(string $st) {
        $this ->file_name = $st;
        if (is_file($st) && is_readable($st)) {
            $this ->file_md5 = md5_file($st);
            $st = file_get_contents($st);
        }elseif (is_dir($st) && is_readable($st)){
            $st = LoadFile::getList($st)[0];
            $this ->file_md5 = md5_file($st);
            $st = file_get_contents($st);
        }elseif (strpos($st, SYS_EOL) === false)
            throw new E('这可能不是一个有效的文件夹');
        $this ->st = str_replace("\r\n", SYS_EOL, str_replace("\n\n", "\n", $st));
    }

    /**
     * 获取标题
     * @return string
     */
    public function getTitle() {
        $title = Cache::get($this ->file_md5 . 'title');
        if (!$title) {
            $title = [];
            $arr = explode(SYS_EOL, $this->st);
            for ($i = 0; $i < 10; $i++) {
                if (preg_match('/^\~\s(.*?)\s\~$/', trim($arr[$i] ?? ''), $title)){
                    $title = end($title);
                    Cache::set('title', $title);
                    break;
                }
            }
        }
        return $title? $title: basename($this ->file_name);
    }

    /**
     * 获取分类信息
     */
    public function getCatalog() {
        $catalogs = Cache::get($this ->file_md5 . 'catalog');
        if (!$catalogs) {
            $catalog = [];
            preg_match_all('/^\@?\#+\s\w*/miu', $this->st, $catalog);
            $catalogs = [];
            foreach (end($catalog) as $value) {
                $catalogs[]['name'] = ($value[0] == '@'?'@':'') . substr($value, stripos($value, ' ') + 1);
                $last_key = count($catalogs) - 1;
                $catalogs[$last_key]['level'] = substr_count($value, '#');
                $catalogs[$last_key]['pid'] = $catalogs[$last_key]['level'] == 1 ?false: (function () use($catalogs, $catalog, $last_key){
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
            Cache::set($this ->file_md5 . 'catalog', $catalogs);
        }
        return $catalogs;
    }

    /**
     * TODO:: 返回值符合规则即可
     * $arr = [
     *      [] => [
     *          'title'     => 答案,
     *          'catalog'   => 所属分类,
     *          'declare'   => 详情,
     *          'param'     => [
     *              'param'     => 形参名,
     *              'type'      => 参数类型,
     *              'declare'   => 参数作用
     *          ],
     *          'link'      => [
     *              '第一个关联',
     *              '第二个关联'
     *          ],
     *          'code'      => 代码块
     *      ]
     * ]
     */
    public function getSt() {
        $st = Cache::get($this ->file_md5 . 'st');
        if (!$st) {
            $st = [];
            $arr = explode(SYS_EOL, $this ->st);
            $last_key = 0;
            $catalog = '';
            while(($item = next($arr)) !== false) {
                $temp = '';
                if (preg_match('/^\@#+\s(.*)$/', $item, $temp)) { // 另类分类
                    $catalog = '@' . end($temp);
                }elseif (preg_match('/^#+\s(.*)$/', $item, $temp)) { // 匹配分类
                    $catalog = end($temp);
                }elseif (preg_match('/^[^~#@`](\s{3}|\t)\S.*/', $item, $temp)) { // 匹配标题
                    if ($temp = trim(reset($temp))) {
                        $st[$last_key]['title'] = $temp;
                        $st[$last_key]['catalog'] = $catalog;
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
                    $eol = array_key_exists('argc', $_SERVER)? SYS_EOL: WEB_EOL;
                    if (!$st[$last_key - 1]['declare']) $eol = ''; // 我是谁，我在哪，我在干什么？这句代码有什么用？？？为毛没事了？？？？?
                    $st[$last_key - 1]['declare'] = trim($st[$last_key - 1]['declare']) . $eol . trim($temp[1]);
                }elseif (preg_match('/^[^#@`]\s{7}\@\s(.*)$/', $item, $temp)) { // 匹配关联
                    $temp[1] = str_ireplace('，', ',', $temp[1]);
                    $link = explode(',', trim($temp[1]));
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
            Cache::set($this ->file_md5 . 'st', $st);
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