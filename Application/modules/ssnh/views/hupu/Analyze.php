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


<div id="container" style="min-width: 500px; height: 400px;width: 500px; margin: 0 0"></div>

<script>
    $(function () {
        $.ajax({
            type:'get',
            url:'/ssnh/hupu/ajax-test',//请求数据的地址
            success:function(data){

                chart.series[0].setData(data.data);
//                chart.drilldown[0].setData(data.data);

            },
            error:function(e){
            }
        });
        // Create the chart
        var chart = Highcharts.chart('container', {
            chart: {
                type: 'column',
                events: {
                    drillup: function (e) {
                        // 上钻回调事件
                        console.log(e.seriesOptions);
                    },
                    drilldown: function (e) {

                        console.log(e.point.id);
                        $.ajax({
                            type:'get',
                            url:'/ssnh/hupu/ajax-test',//请求数据的地址
                            success:function(data){
                                console.log(e.point.id);
                            },
                            error:function(e){
                            }
                        });
                        if (!e.seriesOptions) {
                            var chart = this;
                                drilldowns = {
                                    'nnh': {
                                        name: 'nnh',
                                        data : [[
                                            'v11.0',
                                            24.13
                                        ],
                                        [
                                            'v8.0',
                                            17.2
                                        ],
                                        [
                                            'v9.0',
                                            8.11
                                        ],
                                        [
                                            'v10.0',
                                            5.33
                                        ],
                                        [
                                            'v6.0',
                                            1.06
                                        ],
                                        [
                                            'v7.0',
                                            0.5
                                        ]
                            ]
                                },
                                'Fruits': {
                                        name: 'Fruits',
                                        data: [
                                            [
                                                'v6.0',
                                                1.06
                                            ],
                                            [
                                                'v7.0',
                                                0.5
                                            ]
                                        ]
                                    },
                                    'Cars': {
                                        name: 'Cars',
                                        data: [
                                            [
                                                'v6.0',
                                                1.06
                                            ],
                                            [
                                                'v7.0',
                                                0.5
                                            ]
                                        ]
                                    }
                                },
                                series = drilldowns[e.point.name];
                            // Show the loading label
                            chart.showLoading('Simulating Ajax ...');
                            setTimeout(function () {
                                chart.hideLoading();
                                chart.addSeriesAsDrilldown(e.point, series);
                            }, 1000);
                        }
                    }
                }
            },
            title: {
                text: '发帖数量横向趋势条形图'
            },
            subtitle: {
                text: '<a href="https://bbs.hupu.com">虎扑论坛</a>'
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: '总的市场份额'
                }
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:.1f}%'
                    }
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
            },
            series: [{
                name: '浏览器品牌',
                colorByPoint: true,
                data: [{
                    name: 'Microsoft Internet Explorer',
                    y: 56.33,
                    drilldown: 'Microsoft Internet Explorer'
                }, {
                    name: 'Chrome',
                    y: 24.03,
                    drilldown: 'Chrome'
                }, {
                    name: 'Firefox',
                    y: 10.38,
                    drilldown: 'Firefox'
                }, {
                    name: 'Safari',
                    y: 4.77,
                    drilldown: 'Safari'
                }, {
                    name: 'Opera',
                    y: 0.91,
                    drilldown: 'Opera'
                }, {
                    name: 'Proprietary or Undetectable',
                    y: 0.2,
                    drilldown: null
                }]
            }],
            drilldown: {
                series: []
            }
           /* drilldown: {
                series: [{
                    name: 'Microsoft Internet Explorer',
                    id: 'nb',
                    data: [
                        [
                            'v11.0',
                            24.13
                        ],
                        [
                            'v8.0',
                            17.2
                        ],
                        [
                            'v9.0',
                            8.11
                        ],
                        [
                            'v10.0',
                            5.33
                        ],
                        [
                            'v6.0',
                            1.06
                        ],
                        [
                            'v7.0',
                            0.5
                        ]
                    ]
                }, {
                    name: 'Chrome',
                    id: 'Chrome',
                    data: [
                        [
                            'v40.0',
                            5
                        ],
                        [
                            'v41.0',
                            4.32
                        ],
                        [
                            'v42.0',
                            3.68
                        ],
                        [
                            'v39.0',
                            2.96
                        ],
                        [
                            'v36.0',
                            2.53
                        ],
                        [
                            'v43.0',
                            1.45
                        ],
                        [
                            'v31.0',
                            1.24
                        ],
                        [
                            'v35.0',
                            0.85
                        ],
                        [
                            'v38.0',
                            0.6
                        ],
                        [
                            'v32.0',
                            0.55
                        ],
                        [
                            'v37.0',
                            0.38
                        ],
                        [
                            'v33.0',
                            0.19
                        ],
                        [
                            'v34.0',
                            0.14
                        ],
                        [
                            'v30.0',
                            0.14
                        ]
                    ]
                }, {
                    name: 'Firefox',
                    id: 'Firefox',
                    data: [
                        [
                            'v35',
                            2.76
                        ],
                        [
                            'v36',
                            2.32
                        ],
                        [
                            'v37',
                            2.31
                        ],
                        [
                            'v34',
                            1.27
                        ],
                        [
                            'v38',
                            1.02
                        ],
                        [
                            'v31',
                            0.33
                        ],
                        [
                            'v33',
                            0.22
                        ],
                        [
                            'v32',
                            0.15
                        ]
                    ]
                }, {
                    name: 'Safari',
                    id: 'Safari',
                    data: [
                        [
                            'v8.0',
                            2.56
                        ],
                        [
                            'v7.1',
                            0.77
                        ],
                        [
                            'v5.1',
                            0.42
                        ],
                        [
                            'v5.0',
                            0.3
                        ],
                        [
                            'v6.1',
                            0.29
                        ],
                        [
                            'v7.0',
                            0.26
                        ],
                        [
                            'v6.2',
                            0.17
                        ]
                    ]
                }, {
                    name: 'Opera',
                    id: 'Opera',
                    data: [
                        [
                            'v12.x',
                            0.34
                        ],
                        [
                            'v28',
                            0.24
                        ],
                        [
                            'v27',
                            0.17
                        ],
                        [
                            'v29',
                            0.16
                        ]
                    ]
                }]
            }*/
        });
    });
</script>
</body>
</html>