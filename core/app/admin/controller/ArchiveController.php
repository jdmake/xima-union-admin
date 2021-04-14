<?php
// +----------------------------------------------------------------------
// | Author: jdmake <503425061@qq.com>
// +----------------------------------------------------------------------
// | Date: 2021/3/18
// +----------------------------------------------------------------------


namespace app\admin\controller;


use app\admin\controller\common\AbsController;

class ArchiveController extends AbsController
{
    protected $model = 'HamsterArchiveModel';
    protected $validate = [
        'list_module' => 'require|功能模块必须选择',
        'list_title' => 'require|栏目名称不能为空',
        'list_url' => 'require|URL规则不能为空',
    ];
}
