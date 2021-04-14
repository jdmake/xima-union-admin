<?php if (!defined('HAMSTER_PATH')) exit(); /*a:3:{s:59:"D:\phpwork\xima-union-admin\core\app\admin\views\error.html";i:1616036283;s:59:"D:\phpwork\xima-union-admin\core\app\admin\views\asset.html";i:1616306538;s:60:"D:\phpwork\xima-union-admin\core\app\admin\views\script.html";i:1615978259;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>错误提示</title>

    <?php include 'D:\phpwork\xima-union-admin\data\cache\template\8cd3bd0eb4ab2af54b448e226a217068.php'; ?>

</head>
<body>

<div class="page-container">

    <div class="main-container">
        <div class="content" style="width: 800px;margin: 0 auto">
            <div class="block">
                <div class="block-header block-title bg-gray-lighter">
                    错误提示
                </div>
                <div class="block-content">
                    <i style="color: #c10000;font-size: 42px;display: inline-block;vertical-align: middle" class="fa fa-fw fa-window-close"></i>
                    <span style="font-size: 16px"><?php echo $message; ?></span>
                    <hr>
                    <div>页面将<?php echo $second; ?>秒后自动跳转，如果没有跳转你可以<a href="<?php echo empty($url) ? 'javascript:window.history.back();' : $url; ?>"> 点击这里手动跳转</a></div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include 'D:\phpwork\xima-union-admin\data\cache\template\bdbb00c460a84939f26bae03ef156b5c.php'; ?>
<script>
    $(function () {
        setTimeout(function () {
            var url = '<?php echo $url; ?>';
            if(url === '') {
                window.history.back();
            }else {
                window.location.href = '<?php echo $url; ?>'
            }
        }, <?php echo $second; ?> * 1000)
    })
</script>
</body>
</html>
