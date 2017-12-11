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
    <link rel="stylesheet" href="<?php echo Yii::$app->getHomeUrl() . 'new-admin/layui-2.2.45/css/layui.css'; ?>">


</head>
<body  class="layui-layout-body">
<?php $this->beginBody() ?>

    <div class="container">
        <div class="layui-layout layui-layout-admin">
            <div class="layui-header">
                <div class="layui-logo">山水年华业主意见集合</div>
                <!-- 头部区域（可配合layui已有的水平导航） -->
<!--                <ul class="layui-nav layui-layout-left">-->
<!--                    <li class="layui-nav-item " data-type="tabAdd"><a href="/ssnh/index/index">控制台</a></li>-->
<!--                    <li class="layui-nav-item"><a href="">商品管理</a></li>-->
<!--                    <li class="layui-nav-item"><a href="">用户</a></li>-->
<!--                    <li class="layui-nav-item">-->
<!--                        <a href="javascript:;">其它系统</a>-->
<!--                        <dl class="layui-nav-child">-->
<!--                            <dd><a href="">邮件管理</a></dd>-->
<!--                            <dd><a href="">消息管理</a></dd>-->
<!--                            <dd><a href="">授权管理</a></dd>-->
<!--                        </dl>-->
<!--                    </li>-->
<!--                </ul>-->
                <ul class="layui-nav layui-layout-right">
                    <li class="layui-nav-item">
                        <a href="javascript:;">
                            <img src="http://t.cn/RCzsdCq" class="layui-nav-img">
                            贤心
                        </a>
                        <dl class="layui-nav-child">
                            <dd><a href="">基本资料</a></dd>
                            <dd><a href="">安全设置</a></dd>
                        </dl>
                    </li>
                    <li class="layui-nav-item"><a href="">退了</a></li>
                </ul>
            </div>
            <div class="layui-side layui-bg-black">
                <div class="layui-side-scroll left-menu"></div>
            </div>
        <?= $content ?>
            <div class="layui-footer">
                <!-- 底部固定区域 -->
            </div>
        </div>
    </div>
</div>


<?php $this->endBody() ?>
</body>
<script type="text/javascript"  src="<?php echo Yii::$app->getHomeUrl() . 'new-admin/layui-2.2.45/layui.js'; ?>"></script>

<script type="text/javascript"  src="<?php echo Yii::$app->getHomeUrl() . 'new-admin/js/nav.js'; ?>"></script>

<script type="text/javascript" src="<?php echo Yii::$app->getHomeUrl() . 'new-admin/js/leftNav.js'; ?>"></script>
<script type="text/javascript" src="<?php echo Yii::$app->getHomeUrl() . 'new-admin/js/index.js'; ?>"></script>

</html>
<?php $this->endPage() ?>
