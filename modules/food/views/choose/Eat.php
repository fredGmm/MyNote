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
AppAsset::addScript($this,'@web/src/lib/jquery/jquery.js');
AppAsset::addScript($this,'@web/src/lib/bootstrap/bootstrap.js');

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

    <?php $this->head() ?>
</head>

<body>

<?php foreach ($data as $per => $food){ ?>
    <div id="test" hidden="hidden" class="foods" > <?php echo $food['food_name']; ?> </div>
    <div hidden="hidden" class="per" > <?php echo $food['per']; ?> </div>
<?php } ?>


<div class="option">
    <div class="options">
        <ul>
            <li hidden="hidden">
                标签个数：
                <select  id="tag-number" >
                    <option value="1">1</option>
                    <option value="3">3</option>
                    <option value="5" selected>5</option>
                    <option value="7">7</option>
                    <option value="11" >11</option>
                    <option value="25" >25</option>
                    <option value="34">34</option>
                    <option value="49">49</option>
                    <option value="52">52</option>
                </select>
            </li>
            <li hidden="hidden">
                容器宽高：
                <select id="tag-boxsize">
                    <option value="1200*520" selected>1200*520</option>
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
    <a href="javascript:;" id="go">
        我到底吃啥？♋☹♋
    </a>
</div>
<div class="main">
    <div class="tag-cloud"></div>
</div>
<script type="text/javascript" src="/src/lib/jquery/food/jquery.min.js"></script>
<script type="text/javascript" src="/src/lib/jquery/food/jquery-select2/js/select2.min.js"></script>
<script type="text/javascript" src="/src/lib/jquery/food/jquery.tag-cloud.min.js"></script>
<script type="text/javascript" src="/src/js/food/index.js"></script>


</body>
</html>
<script type="text/javascript" >
</script>






