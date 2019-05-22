<?php

class H_App{

    /**
     * 获取ST文件列表
     * @return string
     * @throws E
     */
    public function fileList() {
        $file_list = LoadFile::getList(dirname(ROOT_PATH) . DS . 'ST');
        foreach ($file_list as &$value){
            $value = (new Parse($value)) ->getTitle();
        }
        return resp($file_list);
    }

    /**
     * 交接给TestObj处理
     * @param $action
     * @param mixed ...$param
     * @return string
     * @throws E
     */
    public function start($action, ...$param) {
        // 合并POST param参数
        $param = array_merge(array_filter($param), [$_POST['param'] ?? '']);
        // 获取到指定的st文件
        $filename = LoadFile::getList(dirname(ROOT_PATH) . DS . 'ST');
        if (array_key_exists($file_index = $_POST['file'] ?? 0, $filename)) {
            $filename = $filename[$file_index];
            $resp = (new TestObj($filename)) ->$action(...$param);
            return resp($resp? $resp: '没有获取到数据', $resp? null: 1003);
        }else {
            return resp('找不到该文件', null, 1006);
        }
    }
}
