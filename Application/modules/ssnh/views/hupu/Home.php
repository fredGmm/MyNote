<div class="layui-inline">
<i class="layui-icon" id="rili"  style="font-size: 40px; color: #1E9FFF;display : inline;">&#xe637;
    <input type="text" style="height: 30px; width:200px;font-size: 30px;color: #1E9FFF;"   id="date_input" >
    <button class="layui-btn" style="height: 40px; margin-top: 10px" id="sure_btn">确定</button>
</i>



</div>


<table class="layui-table" lay-data="{ url:'/ssnh/hupu/article-list/', page:true, id:'article_list'}" >
    <thead>
    <tr>
        <th lay-data="{field:'id', width:80, sort: true}">ID</th>
        <th lay-data="{field:'article_id', width:200}">文章id</th>
        <th lay-data="{field:'article_title', width:500}">文章标题</th>
        <th lay-data="{field:'article_author_name',width:120}">作者昵称</th>
        <th lay-data="{field:'post_date',width:200,sort:true}">发布日期</th>
        <th lay-data="{field:'comment_num',sort:true,width:150}">评论数</th>
        <th lay-data="{field:'browse_num',sort:true,width:200}">浏览数</th>

    </tr>
    </thead>
</table>


<table id="demo" lay-filter="test"  ></table>
    

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
    layui.use('table', function(){

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
</script>
