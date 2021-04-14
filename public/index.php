<?php
// +----------------------------------------------------------------------
// | Author: jdmake <503425061@qq.com>
// +----------------------------------------------------------------------
// | Date: 2021/3/16
// +----------------------------------------------------------------------
require_once __DIR__ . '/../core/library/boot.php';

define('DEFAULT_MODULE', 'admin');
define('APP_DOMAIN', strtolower($_SERVER['HTTP_HOST']));


\library\App::run(1);
