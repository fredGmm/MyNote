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
    <script src="https://img.hcharts.cn/highcharts/modules/series-label.js"></script>

</head>

<div class="layui-inline">
<i class="layui-icon" id="rili"  style="font-size: 20px; color: #1E9FFF;display : inline;">&#xe637;
    <input type="text" style="height: 20px; width:200px;font-size: 20px;color: #1E9FFF;"   id="date_input" >
<!--    <button class="layui-btn" style="height: 20px; margin-top: 10px" id="sure_btn">确定</button>-->
</i>

</div>
<table class="layui-table" lay-data="{ url:'/ssnh/hupu/article-list/', page:true, id:'article_list'}" >
    <thead>
    <tr>
        <th lay-data="{field:'id', width:80, sort: true}">ID</th>
        <th lay-data="{field:'article_id', width:200}">文章id</th>
        <th lay-data="{field:'article_title', width:300}">文章标题</th>
        <th lay-data="{field:'article_author_name',width:200}">作者昵称</th>
        <th lay-data="{field:'post_date',width:200,sort:true}">发布日期</th>
        <th lay-data="{field:'comment_num',sort:true,width:100}">评论数</th>
        <th lay-data="{field:'browse_num',sort:true,width:100}">浏览数</th>

    </tr>
    </thead>
</table>
<hr>
<div id="line-chart" style="max-width:800px;height:400px"></div>


<script>
    layui.use(['form','layer','jquery','table'],function() {
        var form = layui.form,
            layer = parent.layer === undefined ? layui.layer : parent.layer,
            laypage = layui.laypage,
            table = layui.table,
            $ = layui.jquery;

        $("#sure_btn").click(function () {
            date = $("#date_input").val();
            table.reload('article_list', {
                url: '/ssnh/hupu/article-list',
                where:{
                   date: date
                }
                //,height: 300
            });
        })
    });

    layui.use('laydate', function(){
        var laydate = layui.laydate;
        //执行一个laydate实例
        laydate.render({
            elem: '#date_input', //指定元素
            value:new Date(),
            trigger: 'click' //采用click弹出
        });
    });
    $(function () {
        $.ajax({
            type: 'get',
            url: '/ssnh/hupu/post-num-line-by-hour',//请求数据的地址
            success: function (data) {

                line_chart.addSeries(data.data[0]);
                line_chart.addSeries(data.data[1]);
                line_chart.addSeries(data.data[2]);
                console.log(data.data);
            },
            error: function (e) {
            }
        });

        var line_chart = Highcharts.chart('line-chart', {
            title: {
                text: '各时段发帖数走势图'
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
