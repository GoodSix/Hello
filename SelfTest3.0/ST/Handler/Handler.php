<?php


abstract class Handler_Handler{
    public function test () {
        var_dump(func_get_args());
    }

    public function __toString() {
        return get_class($this);
    }
}