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
     * 额，我也忘了当初写这个方法是干什么用的了
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
     * @param null $index   获取指定下标处的数据, 为空表示获取所有数据
     * @return array
     */
    public function getSt($index = null) {
        if ($index != null) {
            return $this ->st[$index] ?? null;
        }else
            return $this ->st;
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
     * TODO:: 验证
     */
    public function verify() {

    }

    /**
     * debug打印的数据
     * @return array|false|string
     */
    public function __debugInfo() {
        return $this ->st;
    }
}