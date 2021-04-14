<?php
// +----------------------------------------------------------------------
// | Author: jdmake <503425061@qq.com>
// +----------------------------------------------------------------------
// | Date: 2021/3/18
// +----------------------------------------------------------------------


namespace app\admin\controller;

use app\admin\controller\common\WebSiteController;
use library\db\Db;
use library\TreeUtil;

/**
 * 网站栏目
 * Class ListController
 * @package app\admin\controller
 */
class ListController extends WebSiteController
{
    protected $model = 'HamsterListModel';
    protected $validate = [
        'list_module' => 'require|功能模块必须选择',
        'list_title' => 'require|栏目名称不能为空',
        'list_url' => 'require|URL规则不能为空',
    ];

    public function add()
    {
        // 获取全部分类树形列表
        $list = Db::create()
            ->table('hamster_list')
            ->where('web_id=:web_id')
            ->setParameter(['web_id' => input('wid')])
            ->getResult();
        TreeUtil::config([
            'id' => 'list_id',
            'pid' => 'list_pid',
            'title' => 'list_title',
            'child' => 'child',
            'html' => '┝ ',
            'step' => 4,
        ]);
        $this->extend_vars['list'] = TreeUtil::toList($list);

        if(method() == 'POST') {
            if(empty($_REQUEST['form']['list_pinyin'])) {
                $_REQUEST['form']['list_pinyin'] = convert_pinyin($_REQUEST['form']['list_title']);
            }
            if(empty($_REQUEST['form']['list_shoupin'])) {
                $_REQUEST['form']['list_shoupin'] = convert_pinyin($_REQUEST['form']['list_title'], 1);
            }
        }

        return parent::add();
    }
}
