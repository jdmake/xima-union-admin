<?php
// +----------------------------------------------------------------------
// | Author: jdmake <503425061@qq.com>
// +----------------------------------------------------------------------
// | Date: 2021/3/16
// +----------------------------------------------------------------------


namespace app\admin\controller;


use app\admin\controller\common\AbsController;

class SettingController extends AbsController
{
    protected $model = 'HamsterWebModel';
    protected $validate = [
        'web_domain' => 'require|站点域名不能为空',
        'web_title' => 'require|站点标题不能为空',
        'web_name' => 'require|站点名称不能为空',
    ];

    public function add()
    {
        $templates = glob(APP_PATH . 'template/*');
        foreach ($templates as &$template) {
            $template = basename($template);
        }
        $this->extend_vars['templates'] = $templates;
        return parent::add();
    }
}
