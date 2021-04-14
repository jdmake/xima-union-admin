<?php
// +----------------------------------------------------------------------
// | Author: jdmake <503425061@qq.com>
// +----------------------------------------------------------------------
// | Date: 2021/3/21
// +----------------------------------------------------------------------


namespace app\admin\controller;


use app\admin\controller\common\WebSiteController;
use app\admin\model\HamsterListModel;
use app\admin\model\HamsterWebModel;
use app\admin\service\collection\CollectionService;

/**
 * 采集管理控制器
 * Class CollectionController
 * @package app\admin\controller
 */
class CollectionController extends WebSiteController
{
    protected $model = 'HamsterCollectionModel';
    protected $validate = [
        'collection_name' => 'require|采集服务必须选择',
        'collection_bind_id' => 'require|栏目必须绑定',
        'collection_run_time' => 'require|执行采集的时间不能为空',
    ];

    public function add()
    {
        // 获取采集服务列表
        $collection_services = [];
        $res = glob(APP_CORE . 'app/admin/service/collection/task/*Task.php');
        foreach ($res as &$re) {
            $re = 'app\\admin\\service\\collection\\task\\' . basename($re, '.php');
            $collection_services[] = [
                'name' => (new $re)->getName(),
                'class' => $re
            ];
        }

        $this->extend_vars['collection_services'] = $collection_services;
        $this->extend_vars['list'] = (new HamsterListModel())->getFindAll(input('wid'));

        return parent::add();
    }

    /**
     * 运行采集任务
     */
    public function run()
    {
        $id = input('id');
        $collection = $this->_model->get($id);
        $task = new $collection['collection_name'];
        $collectionService = new CollectionService($task);

        $domain = (new HamsterWebModel())->get($collection['web_id'])['web_domain'];
        $collectionService->run($domain, $collection['collection_bind_id']);
    }

}
