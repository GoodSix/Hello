<?php

class H_App{

    /**
     * 获取ST文件列表
     * @return string
     * @throws E
     */
    public function fileList() {
        $file_list = LoadFile::getList(dirname(ROOT_PATH) . DS . 'ST');
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
        $filename = LoadFile::getList(dirname(ROOT_PATH) . DS . 'ST')[0];

        $resp = (new TestObj($filename)) ->$action(...$param);
        return resp($resp? $resp: '没有获取到数据', $resp? null: 1003);
    }
}
