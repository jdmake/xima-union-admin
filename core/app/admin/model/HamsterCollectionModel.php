<?php
// +----------------------------------------------------------------------
// | Author: jdmake <503425061@qq.com>
// +----------------------------------------------------------------------
// | Date: 2021/3/21
// +----------------------------------------------------------------------


namespace app\admin\model;


use library\Model;

class HamsterCollectionModel extends Model
{
    protected $table = 'hamster_collection';
    protected $pk = 'collection_id';
    protected $like = 'collection_name';
    protected $unique = 'collection_name';
    protected $enable = 'collection_enable';
    protected $title = '采集任务';

    /**
     * 重写分页列表
     * @param string $kw
     * @param int $page
     * @return array
     */
    public function getPageList($kw = '', $page = 1)
    {
        $res = parent::getPageList($kw, $page);
        foreach ($res['items'] as &$item) {
            $item['collection_name'] = (new $item['collection_name'])->getName();
            $item['collection_bind_id'] = (new HamsterListModel())->get($item['collection_bind_id'])['list_title'];
        }
        return $res;
    }

}
