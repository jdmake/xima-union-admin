<?php
// +----------------------------------------------------------------------
// | Author: jdmake <503425061@qq.com>
// +----------------------------------------------------------------------
// | Date: 2021/4/13
// +----------------------------------------------------------------------


namespace app\admin\controller;


use app\admin\controller\common\AbsController;

/**
 * 保洁管理控制器
 */
class CleanerController extends AbsController
{
    /**
     * 保洁列表
     */
    public function index() {

        return view('cleaner/index', [
            'controller_name' => '保洁管理'
        ]);
    }
}
