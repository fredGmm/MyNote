<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <link rel="icon" href="https://static.jianshukeji.com/highcharts/images/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://img.hcharts.cn/jquery/jquery-1.8.3.min.js"></script>
    <script src="https://img.hcharts.cn/highcharts/highcharts.js"></script>
    <script src="https://img.hcharts.cn/highcharts/modules/exporting.js"></script>
    <script src="https://img.hcharts.cn/highcharts/modules/oldie.js"></script>
    <script src="https://img.hcharts.cn/highcharts/modules/wordcloud.js"></script>
    <script src="https://img.hcharts.cn/highcharts-plugins/highcharts-zh_CN.js"></script>
    <script src="https://img.hcharts.cn/highcharts/modules/drilldown.js"></script>
    <script src="https://img.hcharts.cn/highcharts/modules/data.js"></script>
</head>
<body>



<div id="big-plate-chart" style="min-width:400px;width: 500px;height:400px;margin-left:20px;float: left"></div>

<div id="hot-word" style="min-width:400px;width: 500px;height:400px;margin-left:20px; float: left"></div>
<hr/>
<div id="male" ></div>
<div id="female" style="margin-top: 20px"></div>
<div id="help" style="margin-top: 20px"></span></div>
<hr/>



<script>
    $(function () {
        $.ajax({
            type: 'get',
            url: '/ssnh/hupu/gender-data',//请求数据的地址
            success: function (data) {
                console.log(data.data[0].y);
                $("#male").append("<span style='width:80px;display:inline-block'>男jr:  </span>" + data.data[0].y );
                for(var i=0;i<data.data[0].per;i++){
                    $("#male").append("<span style='margin-left: 10px'><img width=\"20px\" height=\"20px\" src=\"/static/img/male.ico\"></span>");
                }

                $("#female").append("<span style='width:80px;display:inline-block'>女jr: </span>"+ data.data[1].y + "");
                for(var j=0;j<data.data[1].per;j++){
                    $("#female").append("<span style='margin-left: 10px'><img width=\"20px\" height=\"20px\" src=\"/static/img/female.ico\"></span>");
                }

                $("#help").append(" <span style='width:80px;display:inline-block'>无性别jr:</span>"+data.data[2].y);
                for(var k=0;k<data.data[2].per;k++){
                    $("#help").append("<span style='margin-left: 10px'><img width=\"20px\" height=\"20px\" src=\"/static/img/help.ico\"></span>");
                }

            },
            error: function (e) {
            }
        });


        $.ajax({
            type: 'get',
            url: '/ssnh/hupu/hot-word',//请求数据的地址
            success: function (data) {
                console.log(data.data);
                hot_word_chart.series[0].setData(data.data);
            },
            error: function (e) {
            }
        });
        var hot_word_chart = Highcharts.chart('hot-word', {
            series: [{
                type: 'wordcloud'

            }],
            title: {
                text: '热词'
            }
        });

        $.ajax({
            type: 'get',
            url: '/ssnh/hupu/big-plate',//请求数据的地址
            success: function (data) {
//                console.log(data.data);
                big_plate_chart.series[0].setData(data.data);
            }
        });
        var big_plate_chart = Highcharts.chart('big-plate-chart',{
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: '大板块每日发帖的占比图'
            },
            tooltip: {
               headerFormat: '{series.name}<br>',
                pointFormat: '{point.name}: <b>{point.y}篇</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                    }
                }
            },
            series: [{
                type: 'pie',
                name: ' '
            }]
        });
    });
</script>
</body>
</html>