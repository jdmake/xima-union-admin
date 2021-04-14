<?php
// +----------------------------------------------------------------------
// | Author: jdmake <503425061@qq.com>
// +----------------------------------------------------------------------
// | Date: 2021/3/17
// +----------------------------------------------------------------------

namespace app\admin\model;

use library\Model;

/**
 * 站点模型
 * Class HamsterWebModel
 * @package app\admin\model
 */
class HamsterWebModel extends Model
{
    protected $table = 'hamster_web';
    protected $pk = 'web_id';
    protected $like = 'web_domain';
    protected $unique = 'web_domain';
    protected $enable = 'web_enable';
    protected $title = '站点';

    public function add($form)
    {
        $web_domain = $this->getWebTableNameSuffix($form['web_domain']);
        $result = parent::add($form);
        if ($result) {
            // 检查创建站点文档表
            $this->db->exec("
                CREATE TABLE IF NOT EXISTS `hamster_archive_{$web_domain}` (
                  `archive_id` bigint(20) NOT NULL AUTO_INCREMENT,
                  `typeid` smallint(5) unsigned NOT NULL DEFAULT '0',
                  `typeid2` varchar(90) NOT NULL DEFAULT '0',
                  `sortrank` int(10) unsigned NOT NULL DEFAULT '0',
                  `flag` set('c','h','p','f','s','j','a','b') DEFAULT NULL,
                  `ismake` smallint(6) NOT NULL DEFAULT '0',
                  `channel` smallint(6) NOT NULL DEFAULT '1',
                  `arcrank` smallint(6) NOT NULL DEFAULT '0',
                  `click` mediumint(8) unsigned NOT NULL DEFAULT '0',
                  `money` smallint(6) NOT NULL DEFAULT '0',
                  `title` char(60) NOT NULL DEFAULT '',
                  `shorttitle` char(36) NOT NULL DEFAULT '',
                  `color` char(7) NOT NULL DEFAULT '',
                  `writer` char(20) NOT NULL DEFAULT '',
                  `source` char(30) NOT NULL DEFAULT '',
                  `litpic` char(100) NOT NULL DEFAULT '',
                  `pubdate` int(10) unsigned NOT NULL DEFAULT '0',
                  `senddate` int(10) unsigned NOT NULL DEFAULT '0',
                  `mid` mediumint(8) unsigned NOT NULL DEFAULT '0',
                  `keywords` char(30) NOT NULL DEFAULT '',
                  `lastpost` int(10) unsigned NOT NULL DEFAULT '0',
                  `scores` mediumint(8) NOT NULL DEFAULT '0',
                  `goodpost` mediumint(8) unsigned NOT NULL DEFAULT '0',
                  `badpost` mediumint(8) unsigned NOT NULL DEFAULT '0',
                  `voteid` mediumint(8) NOT NULL,
                  `notpost` tinyint(1) unsigned NOT NULL DEFAULT '0',
                  `description` varchar(255) NOT NULL DEFAULT '',
                  `filename` varchar(40) NOT NULL DEFAULT '',
                  `dutyadmin` mediumint(8) unsigned NOT NULL DEFAULT '0',
                  `tackid` int(10) NOT NULL DEFAULT '0',
                  `mtype` mediumint(8) unsigned NOT NULL DEFAULT '0',
                  `weight` int(10) NOT NULL DEFAULT '0',
                  `content` text NOT NULL COMMENT '内容',
                  PRIMARY KEY (`archive_id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
                ");
        }
        return $result;
    }

    public function delete($id)
    {
        $web_domain = $this->getWebTableNameSuffix($id);
        $result = parent::delete($id);
        if ($result) {
            $this->db->table('hamster_list')
                ->where('web_id=:web_id')
                ->setParameter(['web_id' => $id])
                ->delete();
            $this->db->exec("DROP TABLE IF EXISTS `hamster_archive_{$web_domain}`;");
        }
        return $result;
    }

    /**
     * 获取站点表后缀
     * @param $id
     */
    public function getWebTableNameSuffix($id)
    {
        if ($id > 0) {
            $website = $this->get($id);
            $web_domain = str_replace('.', '_', $website['web_domain']);
        } else {
            $web_domain = str_replace('.', '_', $id);
        }
        return $web_domain;
    }

    public function isExists($domain)
    {
        return null != $this->db
                ->where('web_domain=:domain')
                ->setParameter(['domain' => $domain])
                ->find();
    }

    public function isEnable($domain)
    {
        return @$this->db
                ->where('web_domain=:domain')
                ->setParameter(['domain' => $domain])
                ->find()['web_enable'] == 1;
    }

    public function getByDomain($domain)
    {
        $result = $this->db
            ->where('web_domain=:domain')
            ->setParameter(['domain' => $domain])
            ->find();

        $globals = $this->db
            ->table('hamster_global')
            ->where('web_id=:web_id')
            ->where('global_enable=1')
            ->setParameter(['web_id' => $result['web_id']])
            ->getResult();

        foreach ($globals as $global) {
            $result['global'][$global['global_name']] = $global['global_value'];
        }

        return $result;
    }
}
