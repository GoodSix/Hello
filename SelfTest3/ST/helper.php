<?php

if (!function_exists('json')) {
    /**
     * 转换json，转换出错则以指定格式返回错误json
     * @param $json     要转换的内容
     * @return string
     */
    function json(array $json): string {
        $json = json_encode($json);
        if (json_last_error()) {
            return json_encode([
                'err' => 1001,
                'msg' => '转换json出错: ' . json_last_error_msg()
            ]);
        }
        return $json;
    }
}

if (!function_exists('resp')) {
    /**
     * 接口数据格式处理
     * @param $msg       如果这里是数据，那么参数2为状态码，默认为0
     * @param null $data 如果参数1是要返回的数据，那么这里用来存放数据，否则此处应为状态码
     * @param int $code 如果参数1是提示信息才会用到这个响应码
     * @return string       转化格式后的内
     */
    function resp($msg, $data = null, $code = 0) {
        if (is_array($msg)) return json(['data' => $msg, 'err' => $data ?? 0]);
        return json(['msg' => $msg, 'data' => $data, 'err' => $code]);
    }
}

if (!function_exists('token')) {
    /**
     * 生成新的token
     * @param string $token 唯一标识，如果没有重复几率可能会提高
     * @return string
     */
    function token($token = '') {
        $token = md5(md5(time() . $token) . $token . time() . mt_rand(0, 1000));
        $sort = range(0, strlen($token), 3);
        $time = '' . strtotime('+10 minute');
        foreach ($sort as $key => $value) {
            if (!isset($time[$key])) break;
            $token[$value] = $time[$key];
        }
        return $token;
    }
}

if (!function_exists('token_verify')) {
    /**
     * 验证指定token是否为此系统生成的token
     * @param string $token 被验证的token
     * @return bool
     */
    function checkToken($token) {
        $time = '';
        for ($i = 0; $i < strlen($token); $i += 3) {
            $time .= $token[$i];
        }
        $time = substr($time, 0, 10);
        return is_numeric($time) && $time > time();
    }
}

if (!function_exists('isMobile')) {
    /**
     * 检测是否为移动端请求
     * @return bool
     */
    function isMobile() {
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])) {
            return true;
        }
        // 如果via信息含有wap则一定是移动设备
        if (isset ($_SERVER['HTTP_VIA'])) {
            return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
        }
        if (isset ($_SERVER['HTTP_USER_AGENT'])) {
            $clientkeywords = array('nokia',
                'sony',
                'ericsson',
                'mot',
                'samsung',
                'htc',
                'sgh',
                'lg',
                'sharp',
                'sie-',
                'philips',
                'panasonic',
                'alcatel',
                'lenovo',
                'iphone',
                'ipod',
                'blackberry',
                'meizu',
                'android',
                'netfront',
                'symbian',
                'ucweb',
                'windowsce',
                'palm',
                'operamini',
                'operamobi',
                'openwave',
                'nexusone',
                'cldc',
                'midp',
                'wap',
                'mobile'
            );
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
                return true;
            }
        }
    }
}

if (!function_exists('str_split_unicode')) {
    /**
     * UNICODE安全切割字符串，与官方版本str_split使用方式相同
     * @param $str
     * @param int $l
     * @return array|array[]|false|string[]
     */
    function str_split_unicode($str, $length = 1) {
        $tmp = preg_split('~~u', $str, -1, PREG_SPLIT_NO_EMPTY);
        if ($length > 1) {
            $chunks = array_chunk($tmp, $length);
            foreach ($chunks as $i => $chunk) {
                $chunks[$i] = join('', (array) $chunk);
            }
            $tmp = $chunks;
        }
        return $tmp;
    }
}

if (!function_exists('halt')) {
    /**
     * 调式输出
     * @param array $param
     */
    function halt(...$param) {
        header('Content-Type: text/html; charset=UTF-8');
        var_dump(...$param);
        die();
    }
}

if (!function_exists('get_os')) {
    /**
     * 获得访客操作系统
     */
    function get_os() {
        if (!empty($_SERVER['HTTP_USER_AGENT'])) {
            $os = $_SERVER['HTTP_USER_AGENT'];
            if (preg_match('/win/i', $os)) {
                $os = 'Windows';
            } else if (preg_match('/mac/i', $os)) {
                $os = 'MAC';
            } else if (preg_match('/linux/i', $os)) {
                $os = 'Linux';
            } else if (preg_match('/unix/i', $os)) {
                $os = 'Unix';
            } else if (preg_match('/bsd/i', $os)) {
                $os = 'BSD';
            } else {
                $os = 'Other';
            }
            return $os;
        } else {
            return 'unknow';
        }
    }
}

if (!function_exists('browse_info')) {
    /**
     * 获得访问者浏览器
     */
    function browse_info() {
        if (!empty($_SERVER['HTTP_USER_AGENT'])) {
            $br = $_SERVER['HTTP_USER_AGENT'];
            if (preg_match('/MSIE/i', $br)) {
                $br = 'MSIE';
            } else if (preg_match('/Firefox/i', $br)) {
                $br = 'Firefox';
            } else if (preg_match('/Chrome/i', $br)) {
                $br = 'Chrome';
            } else if (preg_match('/Safari/i', $br)) {
                $br = 'Safari';
            } else if (preg_match('/Opera/i', $br)) {
                $br = 'Opera';
            } else {
                $br = 'Other';
            }
            return $br;
        } else {
            return 'unknow';
        }
    }
}