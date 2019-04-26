<?php


class SearchFile {

    /**
     * 从指定目录开始搜索指定类型的文件，
     * @param string $path
     * @param string $extension
     * @return array
     * @throws E
     */
    public static function getList($path = ROOT_PATH, $extension = ST_EXT) {
        if (is_dir($path) && is_readable($path)) {
            $arr = [];
            $read = null;
            $read = function ($path, $extension) use(&$arr, &$read) {
                if (is_dir($path) && is_readable($path)) {
                    $opendir = opendir($path);
                    while($readdir = readdir($opendir)) {
                        if ($readdir == '.' || $readdir == '..') continue;
                        $readpath = $path . DS . $readdir;
                        if (is_dir($readpath)) {
                            $read($readpath, $extension);
                        }elseif (is_file($readpath) && pathinfo($readpath, PATHINFO_EXTENSION) == $extension)
                            $arr[] = $readpath;
                    }
                    closedir($opendir);
                }elseif (is_file($path) && pathinfo($path, PATHINFO_EXTENSION) == $extension)
                    $arr[] = $path;
            };
            $path = realpath($path);
            $read($path, $extension);
            return $arr;
        }else throw new E(realpath($path) . 'The starting location is not a folder', 500);
    }
}