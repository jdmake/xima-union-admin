<?php
// +----------------------------------------------------------------------
// | Author: jdmake <503425061@qq.com>
// +----------------------------------------------------------------------
// | Date: 2021/3/18
// +----------------------------------------------------------------------

namespace library\validator;

class Validation
{
    private $error = [];

    /**
     * @return array
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param array $error
     */
    private function addError($error)
    {
        $this->error[] = $error;
    }


    /**
     * 创建实例
     * @return Validation
     */
    public static function create()
    {
        return new static();
    }

    /**
     * 验证
     */
    public static function validate(array $data, array $rule = [])
    {
        $validation = static::create();
        foreach ($rule as $key => $item) {
            $type = $item;
            $message = '';
            if (strstr($item, '|')) {
                $arr = explode('|', $item);
                $type = $arr[0];
                $message = $arr[1];
            }
            switch ($type) {
                case 'require':
                    if(!isset($data[$key]) || empty($data[$key])) {
                        $validation->addError(!empty($message) ? $message : "{$key}不能为空");
                    }
                    break;
            }
        }
        return $validation;
    }

}
