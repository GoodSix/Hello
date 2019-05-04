<?php


class Handler_Ajax extends Handler_Handler {
    public function next($num) {
        return json_encode($this ->test ->getSt($num));
    }
}