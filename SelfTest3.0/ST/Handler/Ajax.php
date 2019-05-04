<?php


class Handler_Ajax extends Handler_Handler {
    public function next($num) {
        echo json_encode($this ->test ->getSt($num));
    }
}