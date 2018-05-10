<div class="layui-body layui-form marg0">
    <div class="layui-tab marg0" lay-filter="bodyTab">
        <ul class="layui-tab-title  top_tab">
            <li class="layui-this " lay-id=""><i class="iconfont icon-computer"></i> <cite>首页</cite></li>
        </ul>

        <div class="layui-tab-content clildFrame">
            <div class="layui-tab-item layui-show" style="overflow:auto; ">
<!--                <iframe <!--src="/new-admin/page/main.html"-->
                <!DOCTYPE html html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                    <meta charset="utf-8">
                    <meta name="renderer" content="webkit">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
                    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
                    <meta name="apple-mobile-web-app-status-bar-style" content="black">
                    <meta name="apple-mobile-web-app-capable" content="yes">
                    <meta name="format-detection" content="telephone=no">
                    <link rel="stylesheet" type="text/css" href="/static/css/style.css"/>
                    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
                </head>
                <body class="childrenBody">

                <!-- 上方内容 -->
                <div class="box">
                    <div class="head">
                        <span>虎扑福利图</span>
                        <a id="once_again" href="#" style="color: blue">再来一波></a>
                    </div>
                    <!-- 图片内容 -->
                    <ul></ul>
                </div>

                <script>
                    $(function () {
                        show_images();
                        $("#once_again").click(function () {
                            show_images();
                        });
                        function show_images() {
                            $.ajax({
                                type: 'get',
                                url: '/ssnh/hupu/get-images',//请求数据的地址
                                success: function (data) {

                                    box_ul = $(".box>ul");
                                    box_ul.empty();
                                    for(i=0; i<data.data.length; i++){
                                        html = '<li><div class="deatil"><p>'+ data.data[i].title+'</p>' +
                                            '<a href='+ data.data[i].image_url +' target="_blank">点击进入</a> </div> <img src='+ data.data[i].image_path + ' width="160px" height="240px" alt=""/></li>';
                                        box_ul.append(html);
                                    }
                                },
                                error: function (e) {
                                }
                            });
                        }
                    })
                </script>

<!--                <div class="panel_box row" style=" color: red;">-->
<!--                    <div class="panel col" >-->
<!--                        <a href="javascript:;" data-url="page/message/message.html">-->
<!--                            <div class="panel_icon" style=" background-color:green;" >-->
<!--                                <i class="layui-icon" data-icon="&#xe60c;" style="font-size: 46px; color: red;">&#xe60c;</i>-->
<!--                            </div>-->
<!--                            <div class="panel_word  userAll">-->
<!--                                <span>虎扑论坛</span>-->
<!--                                <cite></cite>-->
<!--                            </div>-->
<!--                        </a>-->
<!--                    </div>-->
<!--                    <div class="panel col">-->
<!--                        <a href="javascript:;" data-url="page/user/allUsers.html">-->
<!--                            <div class="panel_icon" style="background-color:#FF5722;">-->
<!--                                <i class="iconfont icon-dongtaifensishu" data-icon="icon-dongtaifensishu"></i>-->
<!--                            </div>-->
<!--                            <div class="panel_word userAll">-->
<!--                                <span> 金融数据</span>-->
<!--                                <!--<cite>新增人数</cite>-->
<!--                            </div>-->
<!--                        </a>-->
<!--                    </div>-->
<!--                    <div class="panel col">-->
<!--                        <a href="javascript:;" data-url="page/user/allUsers.html">-->
<!--                            <div class="panel_icon" style="background-color:#009688;">-->
<!--                                <i class="layui-icon" data-icon="&#xe613;">&#xe613;</i>-->
<!--                            </div>-->
<!--                            <div class="panel_word userAll">-->
<!--                                <span>学习之路</span>-->
<!--                            </div>-->
<!--                        </a>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <blockquote class="layui-elem-quote">-->
<!--                    <p>本站致力小众数据可视化与分析。有建议与侵权请联系qq：572752023<a style="margin-left: 20px" href="http://guixiaoming.cnblogs.com/" target="_blank" class="layui-btn layui-btn-mini">查看博客</a>　　<span style="color:#1E9FFF;">郑重提示：所有数据仅个人使用</span></p>-->
<!--                </blockquote>-->
                <!--<div class="row">-->
                <!--<div class="sysNotice col">-->
                <!--<blockquote class="layui-elem-quote title">更新日志</blockquote>-->
                <!--<div class="layui-elem-quote layui-quote-nm">-->
                <!--<h3># 1.0.0_dev （发行版） - 2017-08-06</h3>-->
                <!--<p>* 后端框架底层搭建</p>-->
                <!--<p>* 常用组件</p>-->
                <!--<p>* 前端模板</p>-->
                <!--<p>* Python 抓取程序准备</p>-->
                <!--<p>* 支持关键字日志组件</p>-->
                <!--<br />-->
                <!--</div>-->
                <!--</div>-->
                <!--<div class="sysNotice col">-->
                <!--<blockquote class="layui-elem-quote title">系统基本参数</blockquote>-->
                <!--<table class="layui-table">-->
                <!--<colgroup>-->
                <!--<col width="150">-->
                <!--<col>-->
                <!--</colgroup>-->
                <!--<tbody>-->
                <!--<tr>-->
                <!--<td>当前版本</td>-->
                <!--<td class="version"></td>-->
                <!--</tr>-->
                <!--<tr>-->
                <!--<td>开发作者</td>-->
                <!--<td class="author"></td>-->
                <!--</tr>-->
                <!--<tr>-->
                <!--<td>网站首页</td>-->
                <!--<td class="homePage"></td>-->
                <!--</tr>-->
                <!--<tr>-->
                <!--<td>服务器环境</td>-->
                <!--<td class="server"></td>-->
                <!--</tr>-->
                <!--<tr>-->
                <!--<td>数据库版本</td>-->
                <!--<td class="dataBase"></td>-->
                <!--</tr>-->
                <!--<tr>-->
                <!--<td>最大上传限制</td>-->
                <!--<td class="maxUpload"></td>-->
                <!--</tr>-->
                <!--<tr>-->
                <!--<td>当前用户权限</td>-->
                <!--<td class="userRights"></td>-->
                <!--</tr>-->
                <!--</tbody>-->
                <!--</table>-->
                <!--&lt;!&ndash;<blockquote class="layui-elem-quote title">最新文章<i class="iconfont icon-new1"></i></blockquote>&ndash;&gt;-->
                <!--&lt;!&ndash;<table class="layui-table" lay-skin="line">&ndash;&gt;-->
                <!--&lt;!&ndash;<colgroup>&ndash;&gt;-->
                <!--&lt;!&ndash;<col>&ndash;&gt;-->
                <!--&lt;!&ndash;<col width="110">&ndash;&gt;-->
                <!--&lt;!&ndash;</colgroup>&ndash;&gt;-->
                <!--&lt;!&ndash;<tbody class="hot_news"></tbody>&ndash;&gt;-->
                <!--&lt;!&ndash;</table> &ndash;&gt;-->
                <!--</div>-->
                <!--</div>-->

                </body>
                </html>
            </div>
        </div>
    </div>
</div>
