<!DOCTYPE html>
<html>
<head>
    <title>dog-photo</title>
    <meta charset="utf-8">
    <style>
        .impowerBox,.impowerBox .status_icon,.impowerBox .status_txt{display:inline-block;vertical-align:middle}
        a{outline:0}
        h1,h2,h3,h4,h5,h6,p{margin:0;font-weight:400}
        a img,fieldset{border:0}
        body{font-family:"Microsoft Yahei";color:#fff;background:0 0}
        .impowerBox{line-height:1.6;position:relative;width:100%;z-index:1;text-align:center}
        .impowerBox .title{text-align:center;font-size:20px}
        .impowerBox .qrcode{width:280px;margin-top:15px;border:1px solid #E2E2E2}
        .impowerBox .info{width:280px;margin:0 auto}
        .impowerBox .status{padding:7px 14px;text-align:left}
        .impowerBox .status.normal{margin-top:15px;background-color:#232323;border-radius:100px;-moz-border-radius:100px;-webkit-border-radius:100px;box-shadow:inset 0 5px 10px -5px #191919,0 1px 0 0 #444;-moz-box-shadow:inset 0 5px 10px -5px #191919,0 1px 0 0 #444;-webkit-box-shadow:inset 0 5px 10px -5px #191919,0 1px 0 0 #444}
        .impowerBox .status.status_browser{text-align:center}
        .impowerBox .status p{font-size:13px}
        .impowerBox .status_icon{margin-right:5px}
        .impowerBox .status_txt p{top:-2px;position:relative;margin:0}
        .impowerBox .icon38_msg{display:inline-block;width:38px;height:38px}

    </style>
    <script type="text/javascript"  src="<?php echo Yii::$app->getHomeUrl() . 'src/lib/jquery/jquery.js'; ?>"></script>
</head>
<body style="background-color: rgb(51, 51, 51); padding: 50px;">
<div class="main impowerBox">
    <div class="loginPanel normalPanel">
        <div class="title">形形色色的友比</div>
        <div class="waiting panelContent">
            <div class="wrp_code"><img class="qrcode lightBorder" src="<?php echo $data['message'] ?>"></div>
            <div class="info">
                <div class="status status_browser js_status normal" id="more">
                    <button id='refresh' type="button">再来一张!</button>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<script>
    $(function () {
        $("#refresh").click(function(){
            window.location.reload();//刷新当前页面.
        });
    })
</script>