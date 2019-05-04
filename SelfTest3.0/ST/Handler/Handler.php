<?php


abstract class Handler_Handler{

    public function __construct() {
        $this ->test = new TestObj('../ST/');
    }

    public function test () {
        var_dump(func_get_args());
    }

    public function __toString() {
        return get_class($this);
    }
}