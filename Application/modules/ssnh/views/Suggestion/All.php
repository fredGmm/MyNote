
<a href=" " class="layui-btn layui-btn-sm" style="margin-top: 10px;"><i class="layui-icon" style="font-size: 10px;">&#xe654;</i>添加</a>
<table id="suggestion_tb" lay-filter="test"  ></table>

<script>
    layui.use('table', function(){
        var table = layui.table;

        //第一个实例
        table.render({
            elem: '#suggestion_tb'
            ,url: '/ssnh/suggestion/list/' //数据接口
            ,page: true //开启分页
            ,cols: [[ //表头
                {field: 'question_id', title: 'ID', width:60, sort: true, fixed: 'left'}
                ,{field: 'question_text', title: '存在的问题', width:200}
                ,{field: 'question_score', title: '业主在乎程度', width:500, sort: true}
            ]]
        });

    });
</script>