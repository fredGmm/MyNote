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
    <script>
        var _hmt = _hmt || [];
        (function() {
            var hm = document.createElement("script");
            hm.src = "https://hm.baidu.com/hm.js?d6e45f606eb597494e19dc2c3eefb6c7";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hm, s);
        })();
    </script>
</head>
<form action="/index/test" method="post" name="test">
    <input type="text" name="food_name" value="123"/>
    <input type="text" name="food_district" value="wuhan"/>
    <?php
        echo  \yii\helpers\Html::hiddenInput(Yii::$app->getRequest()->csrfParam, Yii::$app->getRequest()->getCsrfToken());
    ?>
    <input type="submit" value="提交">
</form>
