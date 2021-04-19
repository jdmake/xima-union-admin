<?php
// +----------------------------------------------------------------------
// | Author: jdmake <503425061@qq.com>
// +----------------------------------------------------------------------
// | Date: 2021/4/13
// +----------------------------------------------------------------------


namespace app\admin\controller;


use app\admin\controller\common\AbsController;
use app\admin\model\CleanerModel;
use app\admin\model\MemberModel;
use library\Model;

/**
 * 保洁管理控制器
 */
class CleanerController extends AbsController
{
    /**
     * 保洁列表
     */
    public function index()
    {
        return view('cleaner/index', [
            'controller_name' => '保洁管理'
        ]);
    }

    /**
     * 获取保洁数据列表
     */
    public function getData()
    {
        $page = input('page', 1);

        $model = new CleanerModel();
        $pagination = $model->pagination($page, 15);

        foreach ($pagination['items'] as $item) {
            var_dump($item);
        }

        $this->json([
            'draw' => 1,
            'recordsTotal' => $pagination['total'],
            'recordsFiltered' => $pagination['total'],
            'data' => $pagination['items']
        ]);
    }

    /**
     * 添加保洁员
     */
    public function add()
    {
        if(method() == 'POST') {
            $mobile = input('mobile');

            $model = new MemberModel();
            $member = $model->where(['mobile' => $mobile])->find();
            if(null == $member) {
                $this->json([
                    'error' => 1,
                    'msg' => '用户不存在或已被删除'
                ]);
            }

            $model = new CleanerModel([
                'union_id' => $_SESSION['union_id'],
                'uid' => $member->uid,
                'status' => 1
            ]);
            $model->save();
            $this->json([
                'error' => 0,
                'msg' => '添加保洁员成功',
            ]);
        }
    }

    /**
     * 删除保洁
     */
    public function delete()
    {
        $id = input('ids');

        $this->json([
            'error' => 0,
            'msg' => '删除保洁',
            'data' => $id
        ]);
    }


}
