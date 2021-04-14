<?php
// +----------------------------------------------------------------------
// | Author: jdmake <503425061@qq.com>
// +----------------------------------------------------------------------
// | Date: 2021/3/20
// +----------------------------------------------------------------------


namespace app\admin\model;


use library\Model;

class HamsterGlobalModel extends Model
{
    protected $table = 'hamster_global';
    protected $pk = 'global_id';
    protected $like = 'global_name';
    protected $unique = 'global_name';
    protected $enable = 'global_enable';
    protected $title = '全局变量';
}
