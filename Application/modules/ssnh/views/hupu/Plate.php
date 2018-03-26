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

<div id="online-time" style="min-width:400px;height:400px;float: left"></div>



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
            credits: {
                text: 'fredGui的github',
                href: 'https://github.com/fredGmm'
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
        $.ajax({
            type: 'get',
            url: '/ssnh/hupu/ajax-test',//请求数据的地址
            success: function (data) {
//                console.log(data.data);
                online_time.series[0].setData(data.data);
            }
        });
        var online_time = Highcharts.chart('online-time',{
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: 0,
                plotShadow: false
            },
            title: {
                text: '浏览器<br>占比',
                align: 'center',
                verticalAlign: 'middle',
                y: 50
            },
            tooltip: {
                headerFormat: '{series.name}<br>',
                pointFormat: '{point.name}: <b>{point.percentage:.1f}%</b><br>总共100人'
            },
            plotOptions: {
                pie: {
                    dataLabels: {
                        enabled: true,
                        distance: -50,
                        style: {
                            fontWeight: 'bold',
                            color: 'white',
                            textShadow: '0px 1px 2px black'
                        }
                    },
                    startAngle: -90,
                    endAngle: 90,
                    center: ['50%', '75%']
                }
            },
            series: [{
                type: 'pie',
                name: '浏览器占比',
                innerSize: '50%',
//                data: [
//                    ['Firefox',   45.0],
//                    ['IE',       26.8],
//                    ['Chrome', 12.8],
//                    ['Safari',    8.5],
//                    ['Opera',     6.2],
//                    {
//                        name: '其他',
//                        y: 0.7,
//                        dataLabels: {
//                            // 数据比较少，没有空间显示数据标签，所以将其关闭
//                            enabled: false
//                        }
//                    }
//                ]
            }]
        });
    });

</script>
</body>
</html>