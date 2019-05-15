<?php

if (!function_exists('json')) {
    /**
     * 转换json，转换出错则以指定格式返回错误json
     * @param $json 要转换的内容
     * @return string
     */
    function json(array $json):string {
        $json = json_encode($json);
        if (json_last_error()) {
            return json_encode([
                'err'   => 1001,
                'msg'   => '转换json出错'
            ]);
        }
        return $json;
    }
}

if (!function_exists('resp')) {
    function resp($msg, $code = 0) {
        if (is_array($msg)) return json($msg);
        return json(['err' => $code,'msg' => $msg]);
    }
}