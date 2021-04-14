<?php
// +----------------------------------------------------------------------
// | Author: jdmake <503425061@qq.com>
// +----------------------------------------------------------------------
// | Date: 2021/3/18
// +----------------------------------------------------------------------


namespace library;


use library\db\Db;

abstract class Model
{
    protected $table = '';
    protected $pk = '';
    protected $like = '';
    protected $enable = '';
    protected $unique = '';
    protected $title = '';
    protected $db;

    /**
     * Model constructor.
     * @param $db
     */
    public function __construct()
    {
        $this->db = Db::create();
        $this->db->table($this->table);
    }


    /**
     * 获取分页列表
     * @param string $kw
     * @param int $page
     */
    public function getPageList($kw = '', $page = 1)
    {
        $this->db->table($this->table);

        if (!empty($kw))
            $this->db->where($this->like . ' like :domain')->setParameter(['domain' => "%{$kw}%"]);

        $results = $this->db
            ->order($this->pk . ' desc')
            ->pagination($page, 10, [
                'query' => [
                    'kw' => input('kw')
                ]
            ]);

        return $results;
    }

    /**
     * 添加数据
     * @param $form
     */
    public function add($form)
    {
        $this->db->table($this->table);

        $res = $this->db->where($this->unique . ' = :domain')
            ->setParameter(['domain' => $form[$this->unique]])
            ->find();
        if ($res) {
            throw new \Exception($this->title . '已经存在,请不要重复添加');
        }
        return $this->db->insert($form);
    }

    /**
     * 删除
     * @param $id
     */
    public function delete($id)
    {
        $this->db->table($this->table);

        return $this->db->where($this->pk . ' = :id')->setParameter(['id' => $id])->delete();
    }

    /**
     * 更新
     * @param $form
     */
    public function update($id, $form)
    {
        $this->db->table($this->table);
        $res = $this->db
            ->where($this->pk . ' = :id')
            ->setParameter(['id' => $id])
            ->find();
        if (!$res) {
            throw new \Exception($this->title . '不存在或已被删除');
        }

        if(isset($form[$this->unique]) && $form[$this->unique] != $res[$this->unique]) {
            $res = $this->db
                ->where($this->unique . ' = :domain')
                ->setParameter([
                    'domain' => $form[$this->unique],
                ])
                ->find();
            if ($res) {
                throw new \Exception($this->title . '已经存在,请不要重复添加');
            }
        }

        $this->db
            ->where($this->pk . ' = :id')
            ->setParameter(['id' => $id])
            ->update($form);

        return true;
    }

    /**
     * 获取
     * @param $id
     */
    public function get($id)
    {
        $this->db->table($this->table);
        return $this->db->where($this->pk . ' = :id')->setParameter(['id' => $id])->find();
    }

    /**
     * 设置可用状态
     * @param $id
     * @param $bool
     */
    public function setEnable($id, $bool)
    {
        $this->db->table($this->table);
        return $this->db->where($this->pk . ' = :id')
            ->setParameter(['id' => $id])
            ->update([
                $this->enable => $bool
            ]);
    }
}
