
<table id="demo" lay-filter="test"  ></table>

<script>
    layui.use('table', function(){
        var table = layui.table;

        //第一个实例
        table.render({
            elem: '#demo'
            ,url: '/ssnh/hupu/article-list/' //数据接口
            ,page: true //开启分页
            ,cols: [[ //表头
                {field: 'id', title: 'ID', width:60, sort: true, fixed: 'left'}
                ,{field: 'article_id', title: '文章id', width:200}
                ,{field: 'article_title', title: '文章标题', width:500, sort: true}
//                ,{field: 'artcile_author_uid', title: '作者id', width:80}
                ,{field: 'article_author_name', title: '作者昵称', width: 120}
                ,{field: 'post_date', title: '发布日期', width: 200, sort: true}
                ,{field: 'comment_num', title: '评论数', width: 150, sort: true}
                ,{field: 'browse_num', title: '浏览数', width: 200}
                ,{field: 'create_time', title: '抓取时间', width: 200, sort: true}
            ]]
        });

    });
</script>
