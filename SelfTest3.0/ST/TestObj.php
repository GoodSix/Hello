<?php


class TestObj extends Parse implements Iterator{

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

    public function current() {
        // TODO: Implement current() method.
    }

    public function next() {
        // TODO: Implement next() method.
    }

    public function key() {
        // TODO: Implement key() method.
    }

    public function valid() {
        // TODO: Implement valid() method.
    }

    public function rewind() {
        // TODO: Implement rewind() method.
    }
    public function __debugInfo() {
        return $this ->st;
    }
}