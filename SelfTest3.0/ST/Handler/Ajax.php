<?php


class Handler_Ajax extends Handler_Handler {
    public function next() {
        var_dump($this ->test);
    }
}