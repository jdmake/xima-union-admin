<?php
// +----------------------------------------------------------------------
// | Author: jdmake <503425061@qq.com>
// +----------------------------------------------------------------------
// | Date: 2021/3/16
// +----------------------------------------------------------------------


namespace app\admin\controller;


class IndexController
{
    public function index() {
        $id = input('id');

        return view('index/index', [
            'id' => $id
        ]);
    }
}
