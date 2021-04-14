<?php
// +----------------------------------------------------------------------
// | Author: jdmake <503425061@qq.com>
// +----------------------------------------------------------------------
// | Date: 2021/3/17
// +----------------------------------------------------------------------

namespace app\admin\model;

use library\Model;
use library\TreeUtil;

/**
 * 网站栏目模型
 * Class HamsterWebModel
 * @package app\admin\model
 */
class HamsterListModel extends Model
{
    protected $table = 'hamster_list';
    protected $pk = 'list_id';
    protected $like = 'list_title';
    protected $unique = 'list_title';
    protected $enable = 'list_enable';
    protected $title = '网站栏目';

    /**
     * 获取网站栏目分页列表
     */
    public function getPageList($kw = '', $page = 1)
    {
        $this->db->where('web_id=:web_id')->setParameter(['web_id'=> input('wid')]);
        $result = parent::getPageList($kw, $page);
        TreeUtil::config([
            'id' => 'list_id',
            'pid' => 'list_pid',
            'title' => 'list_title',
            'child' => 'child',
            'html' => '┝ ',
            'step' => 4,
        ]);
        $result['items'] = TreeUtil::toList($result['items']);
        return $result;
    }

    /**
     * 获取全部栏目
     */
    public function getFindAll($wid)
    {
        TreeUtil::config([
            'id' => 'list_id',
            'pid' => 'list_pid',
            'title' => 'list_title',
            'child' => 'child',
            'html' => '┝ ',
            'step' => 4,
        ]);

        $res = TreeUtil::toList(
            $this->db->where('web_id=:web_id')
                ->setParameter(['web_id'=> $wid])
                ->getResult()
        );

        return $res;
    }

}
