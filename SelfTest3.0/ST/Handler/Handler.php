<?php


abstract class Handler_Handler{
    public function __toString() {
        return get_class($this);
    }
}