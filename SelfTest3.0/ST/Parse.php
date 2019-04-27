<?php


class Parse {

    private static $_self;

    private function __construct(string $st) {
        $this->st = trim($st);
    }

    /**
     * 单例模式生成st对象
     * @param string $st
     * @return Parse
     */
    public static function getInstance(string $st): Parse {
        if (!self::$_self) self::$_self = new self($st);
        return self::$_self;
    }

    /**
     * 获取标题
     * @return string
     */
    public function getTitle() {
        $title = [];
        $arr = explode(PHP_EOL, $this->st);
        for ($i = 0; $i < 10; $i++) {
            if (preg_match('/^\#\s(.*?)\s\#$/', trim($arr[$i]), $title))
                return end($title);
        }
    }

    /**
     * 获取分类信息
     */
    public function getCatalog() {
        $catalog = [];
        preg_match_all('/^\~+\s\w*/miu', $this->st, $catalog);
        $catalogs = [];
        foreach (end($catalog) as $value) {
            $catalogs[]['pid'] = 0;
            $catalogs[count($catalogs) - 1]['name'] = substr($value, stripos($value, ' ') + 1);
            $catalogs[count($catalogs) - 1]['level'] = substr_count($value, '~');
        }
        return $catalogs;
    }

    public function getSt() {
        return 666;
    }

    /**
     * @param $file_name
     * @return mixed
     * @throws E
     */
    public static function st($file_name) {
        if (is_file($file_name) && is_readable($file_name)) {
            $parse = self::getInstance(file_get_contents($file_name));
            $arr['title'] = $parse->getTitle();
            $arr['catalog'] = $parse->getCatalog();
            $arr['st'] = $parse->getSt();
            return $arr;
        } else throw new E('Unable to read the specified file：' . $file_name);
    }
}