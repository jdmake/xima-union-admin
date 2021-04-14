<?php
// +----------------------------------------------------------------------
// | Author: jdmake <503425061@qq.com>
// +----------------------------------------------------------------------
// | Date: 2021/3/21
// +----------------------------------------------------------------------


namespace app\admin\controller\common;


class WebSiteController extends AbsController
{
    /**
     * 重写构造函数，过滤无站点ID的访问
     * ListController constructor.
     */
    public function __construct()
    {
        if(input('wid')) {
            $_SESSION['wid'] = input('wid');
        }

        if(empty(input('wid')) && empty($_SESSION['wid'])) {
            app_error('站点不存在或已被删除');
        }

        $_REQUEST['wid'] = $_SESSION['wid'];

        parent::__construct();
    }
}
