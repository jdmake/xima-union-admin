<?php
// +----------------------------------------------------------------------
// | Author: jdmake <503425061@qq.com>
// +----------------------------------------------------------------------
// | Date: 2021/3/17
// +----------------------------------------------------------------------

namespace app\admin\model;

use library\Model;

/**
 * 管理员模型
 * Class HamsterWebModel
 * @package app\admin\model
 */
class HamsterAdminModel extends Model
{
    protected $table = 'hamster_admin';
    protected $pk = 'admin_id';
    protected $like = 'admin_username';
    protected $unique = 'admin_username';
    protected $enable = 'admin_enable';
    protected $title = '管理员';
}
