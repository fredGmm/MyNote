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


<div style="margin:auto;">

    <div id="big-plate-chart" style="height:300px; margin:0 auto;float: left"></div>
    
</div>


<!--<hr/>-->
<!--<div id="male" ></div>-->
<!--<div id="female" style="margin-top: 20px"></div>-->
<!--<div id="help" style="margin-top: 20px"></span></div>-->
<!--<hr/>-->


<hr/>
<div id="reg-time" style="min-width:400px;width: 1200px;height:400px"></div>

<script>
    $(function () {
//        $.ajax({
//            type: 'get',
//            url: '/ssnh/hupu/gender-data',//请求数据的地址
//            success: function (data) {
//                console.log(data.data[0].y);
//                $("#male").append("<span style='width:80px;display:inline-block'>男jr:  </span>" + data.data[0].y );
//                for(var i=0;i<data.data[0].per;i++){
//                    $("#male").append("<span style='margin-left: 10px'><img width=\"20px\" height=\"20px\" src=\"/static/img/male.ico\"></span>");
//                }
//                $("#female").append("<span style='width:80px;display:inline-block'>女jr: </span>"+ data.data[1].y + "");
//                for(var j=0;j<data.data[1].per;j++){
//                    $("#female").append("<span style='margin-left: 10px'><img width=\"20px\" height=\"20px\" src=\"/static/img/female.ico\"></span>");
//                }
//
//                $("#help").append(" <span style='width:80px;display:inline-block'>无性别jr:</span>"+data.data[2].y);
//                for(var k=0;k<data.data[2].per;k++){
//                    $("#help").append("<span style='margin-left: 10px'><img width=\"20px\" height=\"20px\" src=\"/static/img/help.ico\"></span>");
//                }
//
//            },
//            error: function (e) {
//            }
//        });


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
            url: '/ssnh/hupu/online-time',//请求数据的地址
            success: function (data) {
//                console.log(data.data);
                online_time.series[0].count = data.count;
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
                text: '在线时长<br>占比<br>',
                align: 'center',
                verticalAlign: 'middle',
                y: 50
            },
            tooltip: {
                headerFormat: '{series.name}:{series.count}人<br>',
                pointFormat: '在线{point.name}h: <b>占{point.percentage:.1f}%</b><br>'
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
                name: '总人数',
                innerSize: '50%',
                count:0
            }]
        });

        $.ajax({
            type: 'get',
            url: '/ssnh/hupu/reg-time',//请求数据的地址
            success: function (data) {
//                console.log(data.data);
                for (let i = 0;i < data.data.length;i++){
//                    console.log(data.data[s]);
                    reg_time.addSeries(data.data[i]);
                }
            }
        });
        var reg_time = Highcharts.chart('reg-time',{
            chart: {
                type: 'column'
            },
            title: {
                text: '堆叠柱形图'
            },
            xAxis: {
                categories: ['2004年', '2005年', '2006年', '2007年', '2008年', '2009年', '2010年', '2011年', '2012年', '2013年', '2014年','2015年', '2016年', '2017年', '2018年']
            },
            yAxis: {
                min: 0,
                title: {
                    text: '水果消费总量'
                },
                stackLabels: {
                    enabled: true,
                    style: {
                        fontWeight: 'bold',
                        color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                    }
                }
            },
            legend: {
                align: 'right',
                x: -30,
                verticalAlign: 'top',
                y: 25,
                floating: true,
                backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: false
            },
            tooltip: {
                formatter: function () {
                    return '<b>' + this.x + '</b><br/>' +
                        this.series.name + ': ' + this.y + '<br/>' +
                        '总量: ' + this.point.stackTotal;
                }
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true,
                        color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                        style: {
                            textShadow: '0 0 3px black'
                        }
                    }
                }
            },
        });
    });

</script>
</body>
</html>