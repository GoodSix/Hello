<?php


class Parse {

    public $st = 'ccheng';

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
        return 666;
    }
}