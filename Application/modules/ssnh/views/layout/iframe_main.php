<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\AppAsset;

//AppAsset::register($this);
//AppAsset::addScript($this,'@web/admin/layui-2.2.45/layui.js');

?>
<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <title><?= Html::encode($this->title) ?></title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" media="all" href="<?php echo Yii::$app->getHomeUrl() . 'new-admin/layui-2.2.45/css/layui.css'; ?>">
    <script type="text/javascript"  src="<?php echo Yii::$app->getHomeUrl() . 'new-admin/layui-2.2.45/layui.js'; ?>"></script>



</head>
<body  class="layui-layout-body">
<?php $this->beginBody() ?>
        <?= $content ?>
            <div class="layui-footer">
                <!-- 底部固定区域 -->
            </div>

<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>
