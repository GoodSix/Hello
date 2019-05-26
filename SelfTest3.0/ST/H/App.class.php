<?php

class H_App {

    private $index;

    /**
     * 获取ST文件列表
     * @return string
     * @throws E
     */
    public function fileList() {
        $path = dirname(ROOT_PATH) . DS . 'ST';
        $file_list = LoadFile::getList($path);
        $arr = [];
        $i = 0;
        foreach ($file_list as $key =>$value){
            if (++ $i == $this ->index) return $value;
            $p = dirname(str_replace($path . DS, '', $value));
            $p = '\'' . implode('\'][\'', explode(DS, $p)) . '\'';

            // 尝试根据语法获取标题，如果获取不到则使用文件名用作标题
            $title = (new TestObj($value)) ->getTitle()
                ?? pathinfo($value, PATHINFO_FILENAME);
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
            return resp($resp? $resp: '没有解析到数据', null, 1003);
        }else {
            return resp('找不到该文件', null, 1006);
        }
    }
}
