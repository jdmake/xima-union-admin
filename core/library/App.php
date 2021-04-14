<?php
// +----------------------------------------------------------------------
// | Author: jdmake <503425061@qq.com>
// +----------------------------------------------------------------------
// | Date: 2021/3/16
// +----------------------------------------------------------------------

namespace library;

class App
{
    public static function run($debug = false)
    {
        define('APP_DEBUG', $debug);

        if(APP_DEBUG) {
            ini_set("display_errors", "On");
            ini_set("error_reporting",E_ALL);
        }else {
            error_reporting(0);
            // 错误处理
            set_error_handler(function ($errno, $errstr, $errfile = '', $errline = 0) {
                ob_start();
                header("HTTP/1.1 404 not found");
                echo 'HTTP/1.1 404 not found';
                echo ob_get_clean();
                exit();
            });
            //异常中止处理
            register_shutdown_function(function () {
                if (!is_null($error = error_get_last())) {
                    // 写入日志

                }
            });
        }

        // 加载路由
        $m = strtolower(isset($_GET['m']) ? $_GET['m'] : DEFAULT_MODULE);
        define('CURRENT_MODULE', $m);

        $do = isset($_GET['do']) ? $_GET['do'] : 'index.index';
        $split = explode('.', $do);

        $controller = ucfirst($split[0]);
        define('CURRENT_CONTROLLER', strtolower($controller));
        $class = 'app\\' . $m . '\\controller\\' . $controller . 'Controller';
        $controllerObject = new $class();

        $method = $split[1];

        define('CURRENT_DO', CURRENT_CONTROLLER . '.' . $method);

        ob_start();
        echo call_user_func_array([$controllerObject, $method], []);
        $content = ob_get_clean();
        echo $content;
        exit();
    }
}
