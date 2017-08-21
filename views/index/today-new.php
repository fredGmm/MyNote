<?php
use app\assets\AppAsset;
/* @var $this yii\web\View */
$this->title = 'my arashi %$@^$%';
AppAsset::register($this);
AppAsset::addCss($this,'@web/src/css/default.css');
AppAsset::addScript($this,'@web/src/lib/jquery/jquery.js');
AppAsset::addScript($this,'@web/src/lib/bootstrap/bootstrap.js');
AppAsset::addScript($this,'@web/src/js/main.js')
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7"/>
    <meta name="format-detection" content="telephone=no">
    <meta name="renderer" content="webkit">
    <meta name="author" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="" />
    <meta name="keywords" content="arashi" />
    <?php $this->head() ?>
</head>
<body>
<header>
    <div class="header-nav">
        <div role="navigation">
            <a href="#" rel="home" class="hd-logo" title="嵐"><img src="<?php echo  "/src/images/logo.jpg" ?>"></a>
            <ul class="hd-nav">
                <li class="search-box-li">
                    <div><input type="text" name="search-keyword" placeholder="输入关键词" form="search-keyword"><i
                            class="iconfont search-submit">&#xe617;</i></div>
                    <i class="search-exit"></i></li>
                <li><a href="/index/index" name="index">我们的ARASHI<span><i class="iconfont ">&#xe6aa;</i></span></a></li>
                <li><a href="/index/today-news" name="about" target="_blank">今日新闻<span><i class="iconfont ">&#xe6aa;</i></span></a></li>
                <li><a href="/index/hang-they" name="productlist">交给岚吧<span><i class="iconfont ">&#xe6aa;</i></span></a></li>
                <li><a href="/index/my-nio" name="article">Nio专版<span><i class="iconfont ">&#xe6aa;</i></span></a></li>
                <li><a href="/index/fans-family" name="contact">关于迷妹<span><i class="iconfont ">&#xe6aa;</i></span></a></li>
            </ul>

            <div class="motai"></div>
            <ul>
                <li><a><i class="iconfont search-botton">&#xe617;</i></a></li>
                <li><a>中文</a></li>
                <li><a>En</a></li>
                <li><a><i class="iconfont nav-bottom">&#xe61f;</i></a></li>
            </ul>

        </div>
        <div class="search-box">
            <form method="post" action="#" id="search-keyword">
                <input type="text" name="search-keyword" placeholder="请输入您的内容">
                <span></span>
            </form>

        </div>

    </div>
</header>
<main class="main-first-bgcolor">

    <div class="container" >
        <div class="row" style="height: 180px;background-color: pink ">
            <div class="col-sm-6"></div>
            <div class="col-sm-6"></div>
        </div>
    </div>
    <div class="container" >
        <div class="row" style="height: 30px; ">
            <div class="col-sm-6"></div>
            <div class="col-sm-6"></div>
        </div>
    </div>
    <div class="container" >
        <div class="row">
            <div class="col-sm-6">
<!--                <a class="media-left" href="#">-->
<!--                    <img class="media-object" src="/src/images/arashi/2.jpg" alt="媒体对象">-->
<!--                </a>-->
                <div id="myCarousel" class="carousel slide">
                    <!-- 轮播（Carousel）指标 -->
                    <ol class="carousel-indicators">
                        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#myCarousel" data-slide-to="1"></li>
                        <li data-target="#myCarousel" data-slide-to="2"></li>
                    </ol>
                    <!-- 轮播（Carousel）项目 -->
                    <div class="carousel-inner">
                        <div class="item active">
                            <img src="/src/images/arashi/2.jpg" alt="First slide">
                        </div>
                        <div class="item">
                            <img src="/src/images/arashi/2.jpg" alt="Second slide">
                        </div>
                        <div class="item">
                            <img src="/src/images/arashi/2.jpg" alt="Third slide">
                        </div>
                    </div>
                    <!-- 轮播（Carousel）导航 -->
                    <a class="carousel-control left" href="#myCarousel"
                       data-slide="prev">&lsaquo;</a>
                    <a class="carousel-control right" href="#myCarousel"
                       data-slide="next">&rsaquo;</a>
                </div>
            </div>
            <div class="col-sm-6">
                <ul class="list-group">
                    <li class="list-group-item">二宫和也电影上线</li>
                    <li class="list-group-item">英雄联盟版本更新</li>
                    <li class="list-group-item">运营上线</li>
                    <li class="list-group-item">iLike【阿拉</li>
                    <li class="list-group-item">最强的杰伦</li>
                    <li class="list-group-item">凑数</li>
                </ul>
            </div>
        </div>
    </div>
    
</main>
</body>
