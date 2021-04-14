<?php
// +----------------------------------------------------------------------
// | Author: jdmake <503425061@qq.com>
// +----------------------------------------------------------------------
// | Date: 2021/3/18
// +----------------------------------------------------------------------


namespace app\admin\controller;



use app\admin\controller\common\AbsController;

class AdminController extends AbsController
{
    protected $model = 'HamsterAdminModel';
    protected $validate = [
        'admin_username' => 'require|账号不能为空',
        'admin_password' => 'require|密码不能为空',
    ];

    public function add()
    {
        if(method() == 'POST') {
            $admin_password = $_REQUEST['form']['admin_password'];
            $_REQUEST['form']['admin_password'] = md5($admin_password . 'dsa1^&*()24d45as45d45as45das47');
            if(input('id') > 0 && empty($admin_password)) {
                unset($this->validate['admin_password']);
                unset($_REQUEST['form']['admin_password']);
            }
        }
        return parent::add();
    }
}
