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

    <div class="header-carousel container">
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
                    <img src="<?php echo  "/src/images/banner.jpg" ?>" style="width:100%;" alt="First slide">
                </div>
                <div class="item">
                    <img src="<?php echo  "/src/images/banner2.jpg" ?>" style="width:100%;" alt="Second slide">
                </div>
                <div class="item">
                    <img src="<?php echo  "/src/images/banner3.jpg" ?>" style="width:100%;" alt="Third slide">
                </div>
            </div>
            <!-- 轮播（Carousel）导航 -->
            <a class="carousel-control left" href="#myCarousel"
               data-slide="prev"></a>
            <a class="carousel-control right" href="#myCarousel"
               data-slide="next"></a>
        </div>

    </div>
</header>
<main class="main-first-bgcolor">
    <div>
        <div class="main-head">
            <p>
                <span>我们提供</span>
            </p>
        </div>
        <div class="main-we-provide">
            <ul>
                <li><span><img src="<?php echo  "/src/images/lunch.png" ?>" alt=""></span>
                    <h2>中餐</h2>
                    <p>公司目前经营的范围包括：电子商务平台开发技术支持、技术转让、运维技术服务大数据、云计算等。</p></li>
                <li><span><img src="<?php echo  "/src/images/dinner.png" ?>" alt=""></span>
                    <h2>晚餐</h2>
                    <p>公司目前经营的范围包括：电子商务平台开发技术支持、技术转让、运维技术服务大数据、云计算等。</p></li>
                <li><span><img src="<?php echo  "/src/images/coffee.png" ?>" alt=""></span>
                    <h2>甜品/咖啡</h2>
                    <p>公司目前经营的范围包括：电子商务平台开发技术支持、技术转让、运维技术服务大数据、云计算等。</p></li>
            </ul>
        </div>
    </div>

    <div>
        <div class="main-head">
            <p>
                <span>菜式欣赏</span>
            </p>
        </div>
    </div>
</main>

<main>
    <img class="mdbanner" src="<?php echo  "/src/images/mdbanner.jpg" ?>">
</main>
<main>
    <div class="main-body">
        <p><span>每一种食物来源都经过我们的精挑细选，关于食材我们只选最天然、健康、优质的，只为一份对极致美味的追求，用心做好每一份菜，是我们不变的宗旨。</span></p>
        <ul class="main-body-img">
            <li><img src="<?php echo  "/src/images/mdlist1.jpg" ?>"></li>
            <li><img src="<?php echo  "/src/images/mdlist2.jpg" ?>"></li>
            <li><img src="<?php echo  "/src/images/mdlist3.jpg" ?>"></li>
            <li><img src="<?php echo  "/src/images/mdlist4.jpg" ?>"></li>
            <li><img src="<?php echo  "/src/images/mdlist5.jpg" ?>"></li>
            <li><img src="<?php echo  "/src/images/mdlist6.jpg" ?>"></li>
            <li><img src="<?php echo  "/src/images/mdlist7.jpg" ?>"></li>
            <li><img src="<?php echo  "/src/images/mdlist8.jpg" ?>"></li>
            <li><img src="<?php echo  "/src/images/mdlist9.jpg" ?>"></li>
        </ul>
    </div>
</main>
<main>
    <ul class="main-submenu">
        <li><a href="#">午餐</a></li>
        <li><a href="#">晚餐</a></li>
        <li><a href="#">甜品</a></li>
        <li><a href="#">饮料</a></li>
    </ul>
    <ul class="main-submenu-info main-submenu-first">
        <li><a href="#">
            <div class="food-name">
                <p>玫瑰香酥西兰花</p>
                <p>Rose fried broccoli</p>
            </div>
            <div class="food-price">
                <p>￥<span>25</span></p>
            </div>
            <div class="img-bg"></div>
            <img src="<?php echo  "/src/images/foodlist1.jpg" ?>"></a></li>
        <li><a href="#">
            <div class="food-name">
                <p>玫瑰香酥西兰花</p>
                <p>Rose fried broccoli</p>
            </div>
            <div class="food-price">
                <p>￥<span>25</span></p>
            </div>
            <div class="img-bg"></div>
            <img src="<?php echo  "/src/images/foodlist2.jpg" ?>"></a></li>
        <li><a href="#"><img src="<?php echo  "/src/images/foodlist3.jpg" ?>"></a></li>
        <li><a href="#"><img src="<?php echo  "/src/images/foodlist4.jpg" ?>"></a></li>
        <li><a href="#"><img src="<?php echo  "/src/images/foodlist5.jpg" ?>"></a></li>
        <li><a href="#"><img src="<?php echo  "/src/images/foodlist6.jpg" ?>"></a></li>
    </ul>
    <a class="more" href="#">MORE</a>
</main>
<main>
    <div>
        <div class="main-head">
            <p><span>美食资讯</span></p>
        </div>
    </div>
    <ul class="main-submenu main-submenu-second">
        <li><a href="#">最新新闻</a></li>
        <li><a href="#">餐厅新闻</a></li>
        <li><a href="#">美食热闻</a></li>
        <li><a href="#">甜品站</a></li>
    </ul>
    <ul class="main-submenu-info ">
        <li><a href="#">
            <div class="activity-duration">
                <img  src="<?php echo  "/src/images/activity-duration.png" ?>">
                <p>6-1日</p>
            </div>
            <img src="<?php echo  "/src/images/foodnewlist1.jpg" ?>">
            <h1 class="food-head">周末轻松制作美味甜品</h1>
            <p class="food-info">每个周末都抽出一个小时的时间来为自己做一份甜品，让周末的休闲充满制作甜蜜和品尝甜蜜的快乐。</p>
        </a></li>
        <li><a href="#">
            <div class="activity-duration">
                <img src="<?php echo  "/src/images/activity-duration.png" ?>">
                <p>6-1日</p>
            </div>
            <img  src="<?php echo  "/src/images/foodnewlist1.jpg" ?>">
            <h1 class="food-head">周末轻松制作美味甜品</h1>
            <p class="food-info">每个周末都抽出一个小时的时间来为自己做一份甜品，让周末的休闲充满制作甜蜜和品尝甜蜜的快乐。</p>
        </a></li>
        <li><a href="#">
            <div class="activity-duration">
                <img src="<?php echo  "/src/images/activity-duration.png" ?>">
                <p>6-1日</p>
            </div>
            <img src="<?php echo  "/src/images/foodnewlist1.jpg" ?>">
            <h1 class="food-head">周末轻松制作美味甜品</h1>
            <p class="food-info">每个周末都抽出一个小时的时间来为自己做一份甜品，让周末的休闲充满制作甜蜜和品尝甜蜜的快乐。</p>
        </a></li>

    </ul>
    <a class="more" href="#">MORE</a>
</main>
<main>

        <div class="main-head">
            <p><span>在线预定</span></p>
        </div>
        <div class="main-reserve">
            <form action="#" method="post" id="food-reserve">
                <ul>
                    <li>
                        <label for="username">姓名</label>
                        <input type="text" name="username" id="username">
                    </li>
                    <li>
                        <label for="phonenumber">电话号码</label>
                        <input type="text" name="phonenumber" id="phonenumber">
                    </li>
                    <li>
                        <label for="email">电子邮件</label>
                        <input type="text" name="email" id="email">
                    </li>
                    <li>
                        <label for="time">时间</label>
                        <input type="text" name="time" id="time">
                    </li>
                    <li>
                        <label for="numberofpeople">人数</label>
                        <input type="text" name="numberofpeople" id="numberofpeople">
                    </li>
                    <li>
                        <label for="date">日期</label>
                        <input type="text" name="date" id="date">
                    </li>
                    <li>
                        <label for="guestbook">留言</label>
                        <input type="text" name="guestbook" id="guestbook">
                    </li>
                </ul>
                <a class="reserve">预定</a>

            </form>
        </div>
</main>

<footer>
    <div>
        <ul class="footer-top">
            <li><a href="index.html">我们的ARASHI</a></li>
            <li><a href="about.html">今日新闻</a></li>
            <li><a href="productlist.html">菜式欣赏</a></li>
            <li><a href="article.html">交给岚吧</a></li>
            <li><a href="contact.html">关于迷妹</a></li>
        </ul>
    </div>
    <div>
        <ul class="footer-body">
            <li>
                <span>电话:</span><span>027-88888888</span>
            </li>
            <li>
                <span>邮箱:</span><span>17771869383@163.com</span>
            </li>
            <li>
                <span>地址:</span><span>湖北武汉洪山区</span>
            </li>
        </ul>
        <ul class="footer-footer">
            <li><i class="iconfont ">&#xe613;</i></li>
            <li><i class="iconfont ">&#xe634;</i></li>
            <li><i class="iconfont ">&#xe602;</i></li>
        </ul>
    </div>
</footer>

</body>
