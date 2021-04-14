<?php
// +----------------------------------------------------------------------
// | Author: jdmake <503425061@qq.com>
// +----------------------------------------------------------------------
// | Date: 2021/3/21
// +----------------------------------------------------------------------


namespace app\admin\controller;


use app\admin\controller\common\WebSiteController;

class FlinkController extends WebSiteController
{
    protected $model = 'HamsterFlinkModel';
    protected $validate = [
        'flink_title' => 'require|链接标题不能为空',
        'flink_url' => 'require|链接URL不能为空',
    ];


}
