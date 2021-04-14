<?php
// +----------------------------------------------------------------------
// | Author: jdmake <503425061@qq.com>
// +----------------------------------------------------------------------
// | Date: 2021/3/21
// +----------------------------------------------------------------------


namespace app\admin\model;


use library\Model;

class HamsterFlinkModel extends Model
{
    protected $table = 'hamster_flink';
    protected $pk = 'flink_id';
    protected $like = 'flink_title';
    protected $unique = 'flink_url';
    protected $enable = 'flink_enable';
    protected $title = '友情链接';
}
