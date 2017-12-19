<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>后台管理系统</title>
    <?php echo \yii\helpers\Html::csrfMetaTags(); ?>
    <link href="<?= $this->baseUrl?>/admin/css/style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="<?= $this->baseUrl?>/admin/js/jquery.js"></script>
</head>

<body>
<div class="container" id="cpcontainer">
    <?php echo $content; ?>
</div>
</body>
</html>
<script type="text/javascript">
    $('.tablelist tbody tr:odd').addClass('odd');
</script>