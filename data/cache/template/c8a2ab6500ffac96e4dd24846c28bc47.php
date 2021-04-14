<?php if (!defined('HAMSTER_PATH')) exit(); /*a:4:{s:67:"D:\phpwork\xima-union-admin\core\app\admin\views\cleaner/index.html";i:1618251291;s:59:"D:\phpwork\xima-union-admin\core\app\admin\views\title.html";i:1618246595;s:59:"D:\phpwork\xima-union-admin\core\app\admin\views\asset.html";i:1616306538;s:61:"D:\phpwork\xima-union-admin\core\app\admin\views\sidebar.html";i:1618247767;}*/ ?>
<div class="sidebar">
    <div class="sidebar-scroll">
        <div class="sidebar-content">
            <div class="side-header">
                <img src="/static/img/logo.png">
            </div>
        </div>
        <div class="side-content">
            <ul class="nav-main">
                <li>
                    <a class="nav-submenu <?php echo CURRENT_CONTROLLER === 'index' ? 'active' : ''; ?>" data-toggle="" href="/">
                        <i class="fa fa-fw fa-home"></i>
                        <span class="sidebar-mini-hide">首页</span>
                    </a>
                </li>
                <li>
                    <a class="nav-submenu <?php echo CURRENT_CONTROLLER === 'cleaner' ? 'active' : ''; ?>" data-toggle="" href="?do=cleaner.index">
                        <i class="fa fa-fw fa-user"></i>
                        <span class="sidebar-mini-hide">保洁管理</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
