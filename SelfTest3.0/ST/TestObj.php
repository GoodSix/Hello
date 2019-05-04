<?php


class TestObj extends Parse{

    private $title;
    private $catalog;
    private $st;

    public function __construct(string $st) {
        parent::__construct($st);
        $this ->title = parent::getTitle();
        $this ->catalog = parent::getCatalog();
        $this ->st = parent::getSt();
    }
    public function getTitle() {
        return $this ->title;
    }
    public function getCatalog($catalog = null) {
        if ($catalog){
            $temp = array_column($this ->catalog, 'name');
            if (($index = array_search($catalog, $temp)) === false)
                return null;
            return $this ->catalog[$index];
        }else
            return $this ->catalog;
    }
    public function getSt($index = null) {
        if ($index !== null) {
            return $this ->st[$index];
        }else
            return $this ->st;
    }

    public function __debugInfo() {
        return $this ->st;
    }
}