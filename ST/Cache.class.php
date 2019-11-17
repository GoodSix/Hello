<?php

class Cache {

    /**
     * 设置一个永久有效的缓存
     * Cache::set('key', 'value')
     * 
     * 设置一个10秒有效的缓存
     * Cache::set('key', 'value', 10)
     * 
     * 获取指定缓存
     * Cache::get('key')
     * 
     * 删除指定缓存
     * Cache::get('key', true) // 也能获取到该数据
     */

    private static function getPath($key) {
        $path = RUNTIME_PATH . DS . 'cache' . DS . md5('cache' . strrev($key) . $key);
        if (!file_exists(dirname($path))) mkdir(dirname($path));
        return $path;
    }

    /**
     * 设置缓存数据
     * @param string $key 键
     * @param mixed $val 存入的值
     * @param int 缓存有效期 /秒
     */
    public static function set($key, $val, $expire = 0) {
        $path = self::getPath($key);

        // if (!mt_rand(0, 10)) { // 设置缓存时，10%几率触发
            try{
                // 删除好久之前的缓存
                $opendir = opendir(dirname($path));
                while($readdir = readdir($opendir)) {
                    if ($readdir == '.' || $readdir == '..') continue;
                    $readdir = dirname($path) . DS . $readdir;
                    $get = unserialize(file_get_contents($readdir));
                    if ($get['expire'] != 0 && $get['expire'] <= time() || (filectime($readdir) + (60 * 60 * 24 * 30) ) < time()) {
                        unlink($readdir);
                    }
                }
                closedir($opendir);
            }catch(E $e) {
    
            }catch(\Error $e){
    
            // }
        }
        
        return file_put_contents($path, serialize([
            'data'  => serialize($val),
            'expire'=> $expire != 0? (time() + $expire): 0
        ])) && true;
    }

    /**
     * 获取缓存数据
     * @param string $key 缓存数据的键
     * @param boolean $del 获取后是否删除该数据
     */
    public static function get($key, $del = false) {
        $get = @file_get_contents($cache_file = self::getPath($key));
        if ($get) {
            if ($del) @unlink($cache_file);
            $get = unserialize($get);
            if ($get['expire'] == 0 || $get['expire'] > time()) {
                $data = unserialize($get['data']);
                if (count($data))
                    return $data;
            }
        }
        return false;
    }
}