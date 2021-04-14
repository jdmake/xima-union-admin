<?php
// +----------------------------------------------------------------------
// | Author: jdmake <503425061@qq.com>
// +----------------------------------------------------------------------
// | Date: 2021/3/16
// +----------------------------------------------------------------------

define('APP_PATH', realpath(__DIR__ . '/../../') . DIRECTORY_SEPARATOR);
define('APP_CORE', APP_PATH . 'core' . DIRECTORY_SEPARATOR);
define('APP_CACHE', APP_PATH . 'data' . DIRECTORY_SEPARATOR);

// 载入类自动加载
require_once APP_CORE . 'library' . DIRECTORY_SEPARATOR . 'Loader.php';
\library\Loader::addPrefix('library\\', APP_CORE . 'library' . DIRECTORY_SEPARATOR);
\library\Loader::addPrefix('app\\', APP_CORE . 'app' . DIRECTORY_SEPARATOR);
\library\Loader::register();

// 载入公共函数库
require_once APP_CORE . 'library' . DIRECTORY_SEPARATOR . 'function.php';

session_start();
