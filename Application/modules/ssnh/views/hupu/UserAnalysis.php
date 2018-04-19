<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <link rel="icon" href="https://static.jianshukeji.com/highcharts/images/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://img.hcharts.cn/jquery/jquery-1.8.3.min.js"></script>
    <script src="https://img.hcharts.cn/highcharts/highcharts.js"></script>
    <script src="https://img.hcharts.cn/highcharts/modules/exporting.js"></script>
    <script src="https://img.hcharts.cn/highcharts/modules/data.js"></script>
    <script src="https://img.hcharts.cn/highcharts/modules/drilldown.js"></script>
    <script src="https://img.hcharts.cn/highcharts-plugins/highcharts-zh_CN.js"></script>
</head>
<body>
<div style="margin:auto;">
    <!-- 性别比例 -->
 <div id="gender-distribution" style="margin:0 auto"></div>
    <!-- 在线时间 -->
 <div id="online-time" style="margin:0 auto;height:300px;float: left"></div>
    <!-- 文章来自的终端占比-->
    <div id="artcile_post_from" style="margin:0 auto;float: left"></div>
</div>
 <script>
     $(function () {

         $.ajax({
             type: 'get',
             url: '/ssnh/hupu/get-article-from',//文章的终端分布接口
             success: function (data) {
//                console.log(data.data);
                 artcile_post_from.series[0].setData(data.data);
             },
             error: function (e) {
             }
         });

         var artcile_post_from = Highcharts.chart('artcile_post_from', {
             chart: {
                 plotBackgroundColor: null,
                 plotBorderWidth: null,
                 plotShadow: false
             },
             credits: {
                 text: 'fredGui的github',
                 href: 'https://github.com/fredGmm'
             },
             title: {
                 text: '发帖所用终端比例分布'
             },
             tooltip: {
                 headerFormat: '{series.name}<br>',
                 pointFormat: '{point.name}: <b>{point.percentage:.1f}%</b>'
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
                 name: '终端分布',
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
             credits: {
                 text: 'fredGui的github',
                 href: 'https://github.com/fredGmm'
             },
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
             url: '/ssnh/hupu/gender-data',//请求数据的地址
             success: function (data) {
//                 console.log(data.data);
                 gender_distribution.series[0].setData(data.data);
             },
             error: function (e) {
             }
         });

         var gender_distribution = Highcharts.chart('gender-distribution', {
             credits: {
                 text: 'fredGui的github',
                 href: 'https://github.com/fredGmm'
             },
             chart: {
                 plotBackgroundColor: null,
                 plotBorderWidth: null,
                 plotShadow: false
             },
             title: {
                 text: '活跃帖子中性别分布'
             },
             tooltip: {
                 headerFormat: '{series.name}<br>',
                 pointFormat: '{point.name}: <b>{point.percentage:.1f}%</b>'
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
                 name: '性别分布'

             }]
         });


     });
 </script>
</body>
</html>