<?php
// +----------------------------------------------------------------------
// | Author: jdmake <503425061@qq.com>
// +----------------------------------------------------------------------
// | Date: 2021/3/16
// +----------------------------------------------------------------------

namespace library;

class Loader
{
    private static $prefixs = [];


    public static function register()
    {
        spl_autoload_register('library\\Loader::autoload', true, false);
    }

    /**
     * 添加前缀
     * @param $prefix
     * @param $path
     */
    public static function addPrefix($prefix, $path)
    {
        self::$prefixs[$prefix] = $path;
    }

    /**
     * 类自动加载入口
     */
    public static function autoload($class)
    {
        self::findFile($class);
    }

    public static function findFile($class)
    {
        foreach (self::$prefixs as $prefix => $path) {
            if(strstr($class, $prefix)) {
                $path = $path . str_replace($prefix, '', $class) . '.php';
                $path = str_replace('\\', DIRECTORY_SEPARATOR, $path);
                self::inclue($path);
            }
        }
    }

    public static function inclue($file)
    {

        return include $file;
    }
}
