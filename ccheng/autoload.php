<?php

foreach ($functions as $function) {
    if ($function) include $function . '.php';
}

spl_autoload_register(function ($class_name) use ($class_map) {
    $class_name = explode('\\', $class_name);
    if (($class_path = array_search($class_name[0], $class_map)) !== false) {
        $class_name[0] = $class_path;
    }
    $class = implode(DIRECTORY_SEPARATOR, $class_name) . '.php';
    if (file_exists($class)) include ($class);
}, false, true);