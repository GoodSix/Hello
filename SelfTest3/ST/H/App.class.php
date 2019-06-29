<?php

class H_App {

    // 操作方法
    public $action;

    private $index;

    protected $path;

    public function __construct() {
        if (strtolower(PHP_OS) == 'linux') {
            $this ->path = '/home/wwwroot/default/data/User/admin/home/ST';
        }else {
            // Windows下做测试用
            $this ->path = dirname(ROOT_PATH) . DS . 'ST';
        }
    }

    public function verify($except) {
        if (array_search($this ->action, $except) === false) {
            $rt = $_SERVER['HTTP_TOKEN'] ?? null;
            if (!isset($rt)
                || empty($rt)
                || !checkToken($rt)
            ) {
                echo resp('身份验证失败', null, 1005);
                die;
            }
        }
    }

    /**
     * 获取ST文件列表
     * @return string
     * @throws E
     */
    public function fileList() {
        $path = $this ->path;

        $file_list = LoadFile::getList($path);
        $arr = [];
        $i = 0;
        foreach ($file_list as $key =>$value){
            if (++ $i == $this ->index) return $value;
            $p = dirname(str_replace($path . DS, '', $value));
            $p = '\'' . implode('\'][\'', explode(DS, $p)) . '\'';

            // 尝试根据语法获取标题，如果获取不到则使用文件名用作标题
            $title = (new TestObj($value)) ->getTitle();
            if (!is_string($title)) $title = pathinfo($value, PATHINFO_FILENAME);
                // 这代码还能继续下去，我认为是有点屎尿了
            // 数据生成
            eval("\$arr[{$p}][$i] = '$title';");

            // 进入下一步需要获取文件路径
        }
        return resp($arr);
    }

    /**
     * 交接给TestObj处理
     * @param $action
     * @param mixed ...$param
     * @return string
     * @throws E
     */
    public function start($action, ...$param) {
        // 获取到指定的st文件
        $this ->index = $_POST['file'] ?? -1;
        $st = $this ->fileList();

        if (is_string($st) && is_file($st)) {
            // 合并POST param参数
            $param = array_merge(array_filter($param), [$_POST['param'] ?? '']);
            $resp = (new TestObj($st)) ->$action(...$param);
            if ($resp) return resp($resp);
            return resp('没有解析到数据', null, 1003);
        }else {
            return resp('找不到该文件', null, 1006);
        }
    }

    /**
     * 获取做题记录
     */
    public function getReduce (){
        $reduce_path = RUNTIME_PATH . DS . 'reduce';

        $opendir = @opendir($reduce_path);
        $data = [];
        if ($opendir) {
            while ($readdir = readdir($opendir)) { // 读取第一层IP数据
                if ($readdir == '.' || $readdir == '..') continue;
                $file = $reduce_path . DS . $readdir;
                $last_key = count($data);
                $data[$last_key]['data'] = @json_decode(file_get_contents($file), true) ?? [];
                // 把子数据转成数组
                foreach ($data[$last_key]['data'] as $k =>$v) {
                    foreach ($v as $key =>$value) {
                        $data[$last_key]['data'][$k][$key] = @json_decode($value) ?? $value;
                    }
                }
                // 更多的相关数据
                $data[$last_key]['time'] = date('Y-m-d H:i', filemtime($file)); // 结束做题时间
                // $data[$readdir]['duration'] = (filemtime($r) - filectime($r)) / 60; // 做题耗时
            }
        }
        @closedir($opendir);
        if (count($data)) {
	    $times = array_column($data, 'time');
	    $data = array_combine($times, $data);
	    krsort($data);
            return resp($data);
        }
        return resp('没有记录', null, 0);
    }

    /**
     * 保存记录
     *      需要post方式传输指定键，并将题目转为json后传输过来进行保存，前端应每次刷新后更新身份标识
     * @param $verify 身份标识
     * @return string
     */
    public function reduce($verify) {
        if ($verify) {
            $reduce_path = RUNTIME_PATH . DS . 'reduce';
            if (!file_exists($reduce_path)) mkdir($reduce_path, 0777, true);
            if (!file_exists($reduce_path)) return resp('无法生成记录文件，可能是服务器端没有权限进行记录，请前往检查', null, 1010);
            $reduce_path .= DS . $verify;
            $reduce = @file_get_contents($reduce_path);
            $reduce = @json_decode($reduce, true) ?? [];
            $reduce[key($_POST)][] = $_POST[key($_POST)];
            file_put_contents($reduce_path, json($reduce));
            return resp('记录成功', null, 0);
        }else {
            return resp('记录失败', null, 1009);
        }
    }

    public function search ($keyword = null) {
        $result = [];
        foreach (LoadFile::getList($this ->path) as $val) {
            $to = new TestObj($val);
            // TODO:: 搜索待续
        }
        if (count($result)) {
            return resp($to);
        }else return resp('搜索结果为空', null, 1);
    }
}
