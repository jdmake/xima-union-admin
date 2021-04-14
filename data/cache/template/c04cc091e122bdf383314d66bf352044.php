<?php if (!defined('HAMSTER_PATH')) exit(); /*a:6:{s:65:"D:\phpwork\xima-union-admin\core\app\admin\views\admin/index.html";i:1616057565;s:59:"D:\phpwork\xima-union-admin\core\app\admin\views\title.html";i:1616046177;s:59:"D:\phpwork\xima-union-admin\core\app\admin\views\asset.html";i:1616306538;s:61:"D:\phpwork\xima-union-admin\core\app\admin\views\sidebar.html";i:1616477794;s:60:"D:\phpwork\xima-union-admin\core\app\admin\views\navbar.html";i:1616477873;s:60:"D:\phpwork\xima-union-admin\core\app\admin\views\script.html";i:1615978259;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include 'D:\phpwork\xima-union-admin\data\cache\template\37153b0133cad5dee9f392c2799fee68.php'; include 'D:\phpwork\xima-union-admin\data\cache\template\8cd3bd0eb4ab2af54b448e226a217068.php'; ?>

</head>
<body>

<div class="page-container">
    <?php include 'D:\phpwork\xima-union-admin\data\cache\template\c8a2ab6500ffac96e4dd24846c28bc47.php'; include 'D:\phpwork\xima-union-admin\data\cache\template\30022a94814d69a9f45472e7355f29ac.php'; ?>

    <div class="main-container">
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="block">
                        <div class="block-header bg-gray-lighter">
                            <h3 class="block-title">管理员列表</h3>
                        </div>
                        <div class="block-content tab-content">
                            <form name="toolbar-form" method="post">
                                <div class="tab-pane active">
                                    <div class="row data-table-toolbar">
                                        <div class="col-sm-12">
                                            <div class="pull-right search-bar">
                                                <input name="kw" class="form-control" type="text" placeholder="输入关键字进行搜索">
                                            </div>
                                            <div class="toolbar-btn-action">
                                                <a title="新增" class="btn btn-primary"
                                                   href="?do=<?php echo CURRENT_CONTROLLER; ?>.add"><i class="fa fa-plus-circle"></i>
                                                    新增</a>
                                                <a title="启用"
                                                   class="btn btn-success ajax-post confirm"
                                                   href="?do=<?php echo CURRENT_CONTROLLER; ?>.enable"><i
                                                        class="fa fa-check-circle-o"></i> 启用</a>
                                                <a title="禁用" class="btn btn-warning ajax-post confirm"
                                                   href="?do=<?php echo CURRENT_CONTROLLER; ?>.disable"><i
                                                        class="fa fa-ban"></i> 禁用</a>
                                                <a title="删除"
                                                   class="btn btn-danger ajax-post confirm"
                                                   href="?do=<?php echo CURRENT_CONTROLLER; ?>.delete"><i
                                                        class="fa fa-times-circle-o"></i> 删除</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-content">
                                        <table class="table table-hover table-condensed">
                                            <thead>
                                            <tr>
                                                <th style="width: 100px;">
                                                    <label class="checkbox-primary">
                                                        <input type="checkbox" id="check-all">
                                                        <span></span>
                                                    </label>
                                                </th>
                                                <th><div>账号</div></th>
                                                <th><div>状态</div></th>
                                                <th><div>操作</div></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach($page['items'] as $item): ?>
                                            <tr>
                                                <th style="width: 100px;">
                                                    <label class="checkbox-primary">
                                                        <input name="ids[]" value="<?php echo $item['admin_id']; ?>" class="sub-checkbox" type="checkbox">
                                                        <span></span>
                                                    </label>
                                                </th>
                                                <td><?php echo $item['admin_username']; ?></td>
                                                <td>
                                                    <label class="switch switch-sm switch-primary">
                                                        <input onchange="enableChange(<?php echo $item['admin_id']; ?>, <?php echo $item['admin_enable']; ?>)" <?php echo $item['admin_enable'] ? 'checked' : ''; ?> type="checkbox">
                                                        <span></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <div class="table-cell">
                                                        <a title="编辑" class="btn btn-xs "
                                                           href="?do=<?php echo CURRENT_CONTROLLER; ?>.add&id=<?php echo $item['admin_id']; ?>"
                                                           data-toggle="tooltip" data-placement="top">
                                                            <i class="fa fa-fw fa-edit"></i>编辑
                                                        </a>
                                                        <a title="删除" class="btn btn-xs confirm"
                                                           href="?do=<?php echo CURRENT_CONTROLLER; ?>.delete&id=<?php echo $item['admin_id']; ?>"
                                                           data-toggle="tooltip" data-placement="top">
                                                            <i class="fa fa-fw fa-remove"></i>删除
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination">
                                            <?php echo $page['page']; ?>
                                        </ul>
                                    </nav>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include 'D:\phpwork\xima-union-admin\data\cache\template\bdbb00c460a84939f26bae03ef156b5c.php'; ?>
<script>
    $(function () {
        $('input[name="kw"]').keypress(function (even) {
            if (even.which === 13) {
                even.preventDefault();
                window.location.href = '?do=<?php echo CURRENT_DO; ?>&kw=' + $(this).val();
            }
        })
    });
    function enableChange(id, enable) {
        var url = '';
        if(enable === 1) {
            url = '?do=<?php echo CURRENT_CONTROLLER; ?>.disable';
        }else {
            url = '?do=<?php echo CURRENT_CONTROLLER; ?>.enable';
        }
        $.ajax({
            method: 'post',
            url: url,
            data: {
                ids: [id]
            }
        }, function (res) {
            console.log(res)
        })
    }
</script>
</body>
</html>
