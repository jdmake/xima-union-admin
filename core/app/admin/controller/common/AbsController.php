<?php
// +----------------------------------------------------------------------
// | Author: jdmake <503425061@qq.com>
// +----------------------------------------------------------------------
// | Date: 2021/3/18
// +----------------------------------------------------------------------


namespace app\admin\controller\common;


abstract class AbsController
{
    protected function json(array $array)
    {
        header('content-type:application/json;charset=utf-8');
        echo json_encode($array);
        exit();
    }
}
