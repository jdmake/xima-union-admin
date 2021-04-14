<?php
// +----------------------------------------------------------------------
// | Author: jdmake <503425061@qq.com>
// +----------------------------------------------------------------------
// | Date: 2021/3/20
// +----------------------------------------------------------------------


namespace app\admin\controller;


use app\admin\controller\common\WebSiteController;

class GlobalController extends WebSiteController
{
    protected $model = 'HamsterGlobalModel';
    protected $validate = [
        'global_name' => 'require|变量名称不能为空',
    ];


}
