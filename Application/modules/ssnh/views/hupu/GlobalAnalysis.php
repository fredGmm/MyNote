<head>
    <link rel="icon" href="https://static.jianshukeji.com/highcharts/images/favicon.ico">
    <script src="https://img.hcharts.cn/jquery/jquery-1.8.3.min.js"></script>
</head>

<!--<div class="layui-inline">-->
<!--    <i class="layui-icon" id="rili" style="font-size: 20px; color: #1E9FFF;display : inline;">&#xe637;-->
<!--        <input type="text" style="height: 20px; width:200px;font-size: 20px;color: #1E9FFF;" id="date_input">-->
<!--        <!--    <button class="layui-btn" style="height: 20px; margin-top: 10px" id="sure_btn">确定</button>-->
<!--    </i>-->
<!--</div>-->
<div>
    <div class="searchTable" style="margin: 10px 20px">
        搜索ID：
        <div class="layui-inline">
            <input class="layui-input" name="id" id="listReload" autocomplete="off">
        </div>
        <button class="layui-btn" data-type="reload">搜索</button>
    </div>
    <div style="margin-left: 20px; margin-right: 20px">
        <!--所有爬取到的文章列表-->
        <table class="layui-hide" id="article_list" lay-filter="user"></table>
    </div>

</div>
<!--<div style="margin:auto;">-->
    <!-- 热词展示 -->
<!--    <div id="hot-word" style="height:300px;margin:0 auto; float: left"></div>-->
<!--</div>-->
<!-- 每小时发帖走势图 -->
<!--<div id="line-chart" style="max-width:1000px;margin:0 auto;height:400px;float: left"></div>-->

<script>
    layui.use('table', function () {
        var table = layui.table;
        //方法级渲染
            table.render({
            elem: '#article_list'
            ,url: '/ssnh/hupu/article-list/'
            ,cellMinWidth: 40 //全局定义常规单元格的最小宽度
            ,cols: [[
                {field:'id', title: 'ID',  sort: true, }
                ,{field:'article_id', title: '文章id', }
                ,{field:'article_title', title: '文章标题',  sort: true}
                ,{field:'article_author_name', title: '作者昵称',}
                ,{field:'post_date', title: '发布日期',align: 'center'}
                ,{field:'comment_num', title: '评论数', sort: true }
                ,{field:'browse_num', title: '浏览数', sort: true},
                    {field:'article_url', title: '操作', sort: true}

            ]]
            ,id: 'tableReload'
            ,page: true
            ,height: 500
        });

        var $ = layui.$, active = {
            reload: function(){
                var listReload = $('#listReload');
                //执行重载
                table.reload('tableReload', {
                    page: {
                        curr: 1 //重新从第 1 页开始
                    }
                    ,where: {
                        key: {
                            id: listReload.val()
                        }
                    }
                });
            }
        };

        $('.searchTable .layui-btn').on('click', function(){
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });

        $("#sure_btn").click(function () {
            date = $("#date_input").val();
            table.reload('article_list', {
                url: '/ssnh/hupu/article-list',
                where: {
                    date: date
                }
                //,height: 300
            });
        })
    });

    layui.use('laydate', function () {
        var laydate = layui.laydate;
        //执行一个laydate实例
        laydate.render({
            elem: '#date_input', //指定元素
            value: new Date(),
            trigger: 'click' //采用click弹出
        });
    });
    $(function () {
        $.ajax({
            type: 'get',
            url: '/ssnh/hupu/hot-word',//请求数据的地址
            success: function (data) {
                hot_word_chart.series[0].setData(data.data);
            },
            error: function (e) {
            }
        });
        var hot_word_chart = Highcharts.chart('hot-word', {
            credits: {
                text: 'fredGui的github',
                href: 'https://github.com/fredGmm'
            },
            series: [{
                type: 'wordcloud'
            }],
            title: {
                text: '网友热词'
            }
        });
        $.ajax({
            type: 'get',
            url: '/ssnh/hupu/post-num-line-by-hour',//每小时的发帖数
            success: function (data) {
                line_chart.addSeries(data.data[0]);
                line_chart.addSeries(data.data[1]);
                line_chart.addSeries(data.data[2]);
//                console.log(data.data);
            },
            error: function (e) {
            }
        });
        
        var line_chart = Highcharts.chart('line-chart', {
            title: {
                text: '各时段发帖数走势图'
            },
            credits: {
                text: 'fredGui的github',
                href: 'https://github.com/fredGmm'
            },
            subtitle: {
                text: '数据来源：<a href="https://bbs.hupu.com" style="color: #0000ff" >虎扑论坛</a>'
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: '发帖数'
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
            },
            plotOptions: {
                series: {
                    label: {
                        connectorAllowed: true
                    },

                }
            },
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            }
        });
    })
</script>

<script src="https://img.hcharts.cn/highcharts/highcharts.js"></script>
<script src="https://img.hcharts.cn/highcharts/modules/exporting.js"></script>
<script src="https://img.hcharts.cn/highcharts/modules/oldie.js"></script>
<script src="https://img.hcharts.cn/highcharts/modules/wordcloud.js"></script>
<script src="https://img.hcharts.cn/highcharts-plugins/highcharts-zh_CN.js"></script>
<script src="https://img.hcharts.cn/highcharts/modules/drilldown.js"></script>
<script src="https://img.hcharts.cn/highcharts/modules/data.js"></script>
<script src="https://img.hcharts.cn/highcharts/modules/series-label.js"></script>
