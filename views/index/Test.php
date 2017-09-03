<?php
/**
 * Created by PhpStorm.
 * User: fred
 * Date: 2017/9/3
 * Time: 17:28
 */

?>
<head>
    <?= \yii\helpers\Html::csrfMetaTags() ?>
</head>
<form action="/index/test" method="post" name="test">
    <input type="text" name="food_name" value="123"/>
    <input type="text" name="food_district" value="wuhan"/>
    <?php
        echo  \yii\helpers\Html::hiddenInput(Yii::$app->getRequest()->csrfParam, Yii::$app->getRequest()->getCsrfToken());
    ?>
    <input type="submit" value="提交">
</form>
