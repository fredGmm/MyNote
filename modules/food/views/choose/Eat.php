<?php
/**
 * Created by PhpStorm.
 * User: fred
 * Date: 2017/8/31
 * Time: 22:01
 */
use app\assets\AppAsset;
\app\assets\AppAsset::register($this);
$this->title = 'what eat?';


AppAsset::addCss($this,'@web/src/css/default.css');


?>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta name="format-detection" content="telephone=no" />
    <meta content="email=no" name="format-detection" />
    <meta name="apple-touch-fullscreen" content="yes" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="/src/lib/jquery/food/jquery-select2/css/select2.min.css">
    <link rel="stylesheet" href="/src/css/food/food.css">
    <style type="text/css">
        table.gridtable {
            font-family: verdana,arial,sans-serif;
            font-size:11px;
            color:#333333;
            border-width: 0px;
            border-color: #666666;
            border-collapse: collapse;
            width: 300px;
        }
        table.gridtable th {
            border-width: 1px;
            padding: 8px;
            border-style: solid;
            border-color: #666666;
            background-color: #dedede;
        }
        table.gridtable td {
            border-width: 1px;
            padding: 8px;
            border-style: solid;
            border-color: #666666;
            background-color: #ffffff;
        }
    </style>
    <?php $this->head() ?>
</head>

<body>
<div>
<div class="header-nav" style="background: #286090; height: 116px">
    <div role="navigation">
        <a href="#" rel="home" class="hd-logo" title="嵐"><img style="opacity: 1;" src="<?php echo  "/src/images/logo.jpg" ?>"></a>
        <ul class="hd-nav">
            <li class="search-box-li">
                <div><input type="text" name="search-keyword" placeholder="输入关键词" form="search-keyword"><i
                        class="iconfont search-submit">&#xe617;</i></div>
                <i class="search-exit"></i></li>
            <li><a href="/index/index" name="index" style="font-size: 30px">我们的ARASHI<span><i class="iconfont ">&#xe6aa;</i></span></a></li>
            <li><a href="/index/today-news" name="about" target="_blank" style="font-size: 25px">今日新闻<span><i class="iconfont ">&#xe6aa;</i></span></a></li>
            <li><a href="http://www.ntv.co.jp/arashinishiyagare/" target="_blank" name="productlist" style="font-size: 25px">交给岚吧<span><i class="iconfont ">&#xe6aa;</i></span></a></li>
            <li><a href="/index/my-nio" name="article" style="font-size: 25px">nino专版<span><i class="iconfont ">&#xe6aa;</i></span></a></li>
            <li><a href="/index/fans-family" name="contact" style="font-size: 25px">关于迷妹<span><i class="iconfont ">&#xe6aa;</i></span></a></li>
        </ul>

        <div class="motai"></div>
        <ul>
            <li><a><i class="iconfont search-botton">&#xe617;</i></a></li>
            <li style="font-size: 25px"><a>中文</a></li>
            <li style="font-size: 25px"><a>En</a></li>
            <li><a><i class="iconfont nav-bottom">&#xe61f;</i></a></li>
        </ul>
        <button class="btn btn-large btn-primary" style="padding-right: 10px;opacity: 0.8;" type="button"><a href="/user/login/index" target="_blank" >会员</a></button>
    </div>
    <div class="search-box">
        <form method="post" action="#" id="search-keyword">
            <input type="text" name="search-keyword" placeholder="请输入您的内容">
            <span></span>
        </form>
    </div>
</div>


</div>
<?php foreach ($data as $per => $food){ ?>
    <div id="test" hidden="hidden" class="foods" > <?php echo $food['food_name']; ?> </div>
    <div hidden="hidden" class="per" > <?php echo $food['per']; ?> </div>
<?php } ?>


<div style="margin-left: 500px; margin-top: 150px; float: left">
    你中午吃几个菜：
    <select  class="js-example-basic-single"  id="tag-number"  >
        <option value="1">1</option>
        <option value="2" selected>2</option>
        <option value="3" >3</option>
    </select>
</div>
<div style="margin-left: 50px;  margin-top: 150px; float: left">
    减肥不？：
    <select  class="js-example-basic-single"  id="tag-number"  >
        <option value="1" selected>正常搭配</option>
        <option value="0" >我要减肥</option>
        <option value="2" >我要长肉</option>
    </select>
</div>


<div class="option">
    <div class="options">
        <ul>
            <li hidden="hidden">
                容器宽高：
                <select id="tag-boxsize">
                    <option value="1200*520" >1200*520</option>
                    <option value="600*400" selected>800*600</option>
                    <option value="400*600" >400*600</option>
                    <option value="1111*555">1111*555</option>
                    <option value="500*500">500*500</option>
                </select>
            </li>
            <li hidden="hidden">
                最小颜色值：
                <select id="tag-mincolor">
                    <option value="#000" selected>#000</option>
                    <option value="#ffffff">#ffffff</option>
                    <option value="#777777">#777777</option>
                    <option value="rgb(200,200,200)">rgb(200,200,200)</option>
                    <option value="rgba(255,255,255,1)">rgba(255,255,255,1)</option>
                    <option value="#cdf">#cdf</option>
                    <option value="#25cd87">#cdf</option>
                </select>
            </li>
            <li hidden="hidden">
                最大颜色值：
                <select id="tag-maxcolor">
                    <option value="#000">#000</option>
                    <option value="#ffffff" selected>#ffffff</option>
                    <option value="#777777">#777777</option>
                    <option value="rgb(200,200,200)">rgb(200,200,200)</option>
                    <option value="rgba(255,255,255,1)">rgba(255,255,255,1)</option>
                    <option value="#cdf">#cdf</option>
                    <option value="#25cd87">#cdf</option>
                </select>
            </li>
            <li hidden="hidden">
                是否显示调试网格：
                <input type="checkbox" id="tag-debug" value="true">
            </li>
            <li hidden="hidden">
                设置圆角：
                <select id="tag-radius">
                    <option value="50%" selected>50%</option>
                    <option value="10px">10px</option>
                </select>
            </li>
            <li hidden="hidden">
                设置背景色：
                <select id="tag-bgcolor">
                    <option value="" selected>随机</option>
                    <option value="#000">#000</option>
                    <option value="#ffffff">#ffffff</option>
                    <option value="#777777">#777777</option>
                    <option value="rgb(200,200,200)">rgb(200,200,200)</option>
                    <option value="rgba(255,255,255,1)">rgba(255,255,255,1)</option>
                    <option value="#cdf">#cdf</option>
                    <option value="#25cd87">#25cd87</option>
                </select>
            </li>
            <li hidden="hidden">
                设置文本色：
                <select id="tag-color">
                    <option value="" selected>随机</option>
                    <option value="#000">#000</option>
                    <option value="#ffffff">#ffffff</option>
                    <option value="#777777">#777777</option>
                    <option value="rgb(200,200,200)">rgb(200,200,200)</option>
                    <option value="rgba(255,255,255,1)">rgba(255,255,255,1)</option>
                    <option value="#cdf">#cdf</option>
                    <option value="#25cd87">#25cd87</option>
                </select>
            </li>
            <li hidden="hidden">
                设置动画：
                <select id="tag-anim">
                    <option value="bomb" selected>bomb</option>
                    <option value="one">one</option>
                    <option value="warp">warp</option>
                </select>
            </li>
            <li hidden="hidden">
                设置动画时间：
                <select id="tag-animtime">
                    <option value="700">700ms</option>
                    <option value="500">500ms</option>
                    <option value="300" selected>300ms</option>
                    <option value="100">100ms</option>
                </select>
            </li>
            <li hidden="hidden">
                设置动画延迟：
                <select id="tag-animdelay">
                    <option value="200">200ms</option>
                    <option value="150">150ms</option>
                    <option value="100" selected>100ms</option>
                    <option value="70">70ms</option>
                    <option value="50">50ms</option>
                </select>
            </li>
            <li hidden="hidden">
                设置计算方式：
                <select id="tag-method">
                    <option value="area" selected>根据面积开方计算</option>
                    <option value="divisor">根据公约数计算</option>
                </select>
            </li>

        </ul>

    </div>
    <div id="div-go">
    <a href="javascript:;" id="go">
        我到底吃啥？
    </a></div>
</div>

<div class="main">
    <div class="food-menu">
        <table class="gridtable">
            <tr>
                <th>菜名</th><th>大盘价格</th><th>小盘价格</th>
            </tr>
            <tr>
                <td>双黄鱼片</td><td>7 元</td><td>6 元</td>
            </tr>
            <tr>
                <td>番茄炒鸡蛋</td><td>4.5</td><td>4 元</td>
            </tr>
        </table>
    </div>
    <div class="tag-cloud"></div>
</div>
<script type="text/javascript" src="/src/lib/jquery/food/jquery.min.js"></script>
<script type="text/javascript" src="/src/lib/jquery/food/jquery-select2/js/select2.min.js"></script>
<script type="text/javascript" src="/src/lib/jquery/food/jquery.tag-cloud.min.js"></script>
<script type="text/javascript" src="/src/js/food/index.js"></script>



</body>
</html>
<script type="text/javascript" >
    $(".js-example-basic-single").select2(); //单选

    $(".js-example-basic-multiple").select2(); //多选

    $(".hd-logo").click(function () {
        if($(".hd-logo img").css('opacity') == 1){
            $(".hd-logo img").css('opacity','0.5')
        }else {
            $(".hd-logo img").css('opacity','1')
        }
    })


</script>






