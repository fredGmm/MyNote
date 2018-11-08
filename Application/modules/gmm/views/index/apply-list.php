<?php
/**
 * Created by PhpStorm.
 * User: fredgui
 * Date: 2018/10/9
 * Time: 22:33
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>报名列表</title>
    <link rel="stylesheet" href="/layui/frame/layui/css/layui.css">
    <!--<link rel="stylesheet" href="http://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">-->
    <link rel="stylesheet" href="/layui/frame/static/css/style.css">
    <link rel="icon" href="/layui/frame/static/image/code.png">
</head>
<body class="body">

<!-- 工具集 -->
<div class="my-btn-box">
            <span class="fl">
                <a class="layui-btn layui-btn-danger radius btn-delect" id="btn-delete-all">批量删除</a>
                <a class="layui-btn btn-add btn-default" id="btn-add">添加</a>
                <a class="layui-btn btn-add btn-default" id="btn-refresh"><i class="layui-icon">&#x1002;</i></a>
            </span>
    <span class="fr">
                <span class="layui-form-label">搜索条件：</span>
                <div class="layui-input-inline">
                    <input type="text" autocomplete="off" placeholder="请输入搜索条件" class="layui-input">
                </div>
                <button class="layui-btn mgl-20">查询</button>
            </span>
</div>

<div class="layui-hide" id="view">

    <div class="layui-form-item">
    <div class="layui-inline">
        <label class="layui-form-label">兼职名称:</label>
        <div class="layui-form-label" id="view_job_name">兼职名称:</div>
    </div>
    </div>

    <div class="layui-form-item">
    <div class="layui-inline">
        <label class="layui-form-label">兼职名称:</label>
        <label class="layui-form-label" id="view_type">兼职名称:</label>
    </div>
        </div>

    <div class="layui-form-item">
    <div class="layui-inline">
        <label class="layui-form-label">兼职名称:</label>
        <label class="layui-form-label" id="view_link_man">兼职名称:</label>
    </div>
    </div>

    <div class="layui-form-item">
    <div class="layui-inline">
        <label class="layui-form-label">兼职名称:</label>
        <label class="layui-form-label" id="view_link_phone">兼职名称:</label>
    </div>
    </div>

    <div class="layui-form-item">
    <div class="layui-inline">
        <label class="layui-form-label">兼职名称:</label>
        <label class="layui-form-label" id="view_link_email">兼职名称:</label>
    </div>
    </div>

    <div class="layui-form-item">
    <div class="layui-inline">
        <label class="layui-form-label">兼职名称:</label>
        <label class="layui-form-label" id="view_place">兼职名称:</label>
    </div>
    </div>

    <div class="layui-form-item">
    <div class="layui-inline">
        <label class="layui-form-label">兼职名称:</label>
        <label class="layui-form-label" id="view_note">兼职名称:</label>
    </div>
    </div>

    <div class="layui-form-item">
    <div class="layui-inline">
        <label class="layui-form-label">兼职名称:</label>
        <label class="layui-form-label" id="view_need_count">兼职名称:</label>
    </div>
    </div>

    <div class="layui-form-item">
    <div class="layui-inline">
        <label class="layui-form-label">兼职名称:</label>
        <label class="layui-form-label" id="view_need_height">兼职名称:</label>
    </div>
    </div>

    <div class="layui-form-item">
    <div class="layui-inline">
        <label class="layui-form-label">兼职名称:</label>
        <div class="layui-form-label" id="view_meeting_time" style="width: 300px">兼职名称:</div>
    </div>
    </div>

    <div class="layui-form-item">
    <div class="layui-inline">
        <label class="layui-form-label">兼职名称:</label>
        <label class="layui-form-label" id="view_start_date">兼职名称:</label>
    </div>
    </div>

    <div class="layui-form-item">
    <div class="layui-inline">
        <label class="layui-form-label">兼职名称:</label>
        <label class="layui-form-label" id="view_end_date">兼职名称:</label>
    </div>
    </div>

    <div class="layui-form-item">
    <div class="layui-inline">
        <label class="layui-form-label">兼职名称:</label>
        <label class="layui-form-label" id="view_salary">兼职名称:</label>
    </div>
    </div>

    <div class="layui-form-item">
    <div class="layui-inline">
        <label class="layui-form-label">兼职名称:</label>
        <label class="layui-form-label" id="view_create_time">兼职名称:</label>
    </div>
    </div>





</div>


<form class="layui-form layui-hide" id="edit" action="">
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">兼职名称</label>
                <div class="layui-input-block" style="width:500px">
                    <input type="text" id="edit_job_name"  name="job_name" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
                </div>
            </div>

            <div class="layui-inline">
                <label class="layui-form-label">兼职类型</label>
                <div class="layui-input-inline">
                    <select id="edit_type" name="type" lay-verify="required" lay-search="">

                        <option value="1">暑假实践</option>
                        <option value="2">寒假实践</option>
                        <option value="3" selected>普通兼职</option>
                    </select>
                </div>
            </div>
        </div>


        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">工作开始日期</label>
                <div class="layui-input-inline">
                    <input type="text" name="start_date" id="edit_start_date" lay-verify="date" placeholder="yyyy-MM-dd" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label">工作结束日期</label>
                <div class="layui-input-inline">
                    <input type="text" name="end_date" id="edit_end_date" lay-verify="date" placeholder="yyyy-MM-dd" autocomplete="off" class="layui-input">
                </div>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">所在地点</label>
            <div class="layui-input-inline">
                <select id="edit_view_place" name="district">
                    <option value="武昌区" selected>武昌区</option>
                    <option value="汉阳区">汉阳区</option>
                    <option value="汉口区">汉口区</option>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">具体地址</label>
            <div class="layui-input-block">
                <input type="text" id="edit_view_place" name="place" lay-verify="title" autocomplete="off" placeholder="请输入具体地址" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">集合时间</label>
                <div class="layui-input-inline">
                    <input type="text" name="meeting_time" id="edit_meeting_time" lay-verify="datetime" placeholder="yyyy-MM-dd HH:ii:ss" autocomplete="off" class="layui-input">
                </div>
            </div>

        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">工资</label>
                <div class="layui-input-inline" style="width: 100px;">
                    <input type="number" id="edit_salary" name="salary" lay-verify="number" placeholder="￥" autocomplete="off" class="layui-input">
                </div>
                元/天

            </div>
            <div class="layui-input-block">
                <input type="text" id="edit_note" name="note" lay-verify="title" autocomplete="off" placeholder="额外说明" class="layui-input">
            </div>

        </div>

<div class="layui-form-item">
    <div class="layui-inline">
        <label class="layui-form-label">联系人</label>
        <div class="layui-input-inline">
            <input type="tel" id="edit_link_man" name="link_man" lay-verify="title" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-inline">
        <label class="layui-form-label">联系手机号</label>
        <div class="layui-input-inline">
            <input type="tel" id="edit_link_phone" name="link_phone" lay-verify="phone" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-inline">
        <label class="layui-form-label">联系邮箱</label>
        <div class="layui-input-inline">
            <input type="text" id="edit_link_email" name="link_email" lay-verify="email" autocomplete="off" class="layui-input">
        </div>
    </div>
</div>


<div class="layui-form-item">
    <label class="layui-form-label">性别要求</label>
    <div class="layui-input-block">
        <input type="radio" name="need_sex" value="1" title="男" >
        <input type="radio" name="need_sex" value="2" title="女">
        <input type="radio" name="need_sex" value="0" title="不限" checked="">
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-inline">
        <label class="layui-form-label">身高</label>
        <div class="layui-input-inline" style="width: 100px;">
            <input type="number" id="edit_need_height" name="need_height" value="160" placeholder="160" autocomplete="off" class="layui-input">

        </div>
        <!-- <div class="layui-form-mid layui-word-aux">以上</div> -->
        <div class="layui-inline layui-word-aux"><label class="layui-form-label">cm以上</label></div>

    </div>

</div>

<div class="layui-form-item layui-form-text">
    <label class="layui-form-label">编辑器</label>
    <div class="layui-input-block">
        <textarea class="layui-textarea layui-hide" name="warning" lay-verify="content" id="LAY_demo_editor"></textarea>
    </div>
</div>
<div class="layui-form-item">
    <div class="layui-input-block">
        <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
    </div>
</div>
</form>




<!-- 表格 -->
<div id="dateTable" lay-filter="joblist"></div>


<script type="text/javascript" src="/layui/frame/layui/layui.js"></script>
<script type="text/javascript" src="/layui/js/index.js"></script>
<script type="text/javascript">

    // layui方法
    layui.use(['table', 'form', 'layer', 'vip_table', 'layedit', 'laydate'], function () {

        // 操作对象
        var form = layui.form
            , table = layui.table
            ,layer = layui.layer
            ,layedit = layui.layedit
            ,laydate = layui.laydate
            , vipTable = layui.vip_table
            , $ = layui.jquery;

        // 表格渲染
        var tableIns = table.render({
            elem: '#dateTable'                  //指定原始表格元素选择器（推荐id选择器）
            , height: vipTable.getFullHeight()    //容器高度
            , cols: [[                  //标题栏
                {checkbox: true, sort: true, fixed: false, space: true}
                ,{field: 'id', title: 'ID', width: 80}
                , {field: 'user_id', title: '兼职名称', width: 120}
                , {field: 'job_id', title: '开始时间', width: 100}
                , {field: 'create_time', title: '结束时间', width: 100}
                , {field: 'update_time', title: '集合时间', width: 180}
                , {field: 'linkUser.id', title: '工资', width: 180}
                // , {field: 'status', title: '状态', width: 70}
                , {fixed: false, title: '操作', width: 150, align: 'center', toolbar: '#barOption'} //这里的toolbar值是模板元素的选择器
            ]]
            , id: 'dataCheck'
            , url: '/job/apply-list'
            , method: 'get'
            , page: true
            , limits: [30, 60, 90, 150, 300]
            , limit: 30 //默认采用30
            , loading: false
            , done: function (res, curr, count) {
                //如果是异步请求数据方式，res即为你接口返回的信息。
                //如果是直接赋值的方式，res即为：{data: [], count: 99} data为当前页数据、count为数据总长度
                console.log(res);

                //得到当前页码
                console.log(curr);

                //得到数据总量
                console.log(count);
            }
        });

        // 获取选中行
        table.on('checkbox(dataCheck)', function (obj) {
            layer.msg('123');
            console.log(obj.checked); //当前是否选中状态
            console.log(obj.data); //选中行的相关数据
            console.log(obj.type); //如果触发的是全选，则为：all，如果触发的是单选，则为：one
        });

        table.on('tool(joblist)', function(obj){ //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
            var data = obj.data; //获得当前行数据
            var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）
            var tr = obj.tr; //获得当前行 tr 的DOM对象

            if(layEvent === 'detail'){ //查看

                $.ajax({
                    type: 'get',
                    url: '/job/view?id=' + data.id ,//请求数据的地址

                    success: function (data) {
                        data = JSON.parse(data);
                        if ( data.status == 'success') {
                            info = data.data;

                            $("#view_type").html(info.type);
                            $("#view_job_name").html(info.job_name);
                            $("#view_link_man").html(info.link_man);
                            $("#view_link_phone").html(info.link_phone);
                            $("#view_link_email").html(info.link_email);
                            $("#view_place").html(info.place);
                            $("#view_note").html(info.note);
                            $("#view_need_count").html(info.need_count);
                            $("#view_need_height").html(info.need_height);
                            $("#view_meeting_time").html(info.meeting_time);
                            $("#view_start_date").html(info.start_date);
                            $("#view_end_date").html(info.end_date);
                            $("#view_salary").html(info.salary);
                            $("#view_create_time").html(info.create_time);


                            //do somehing
                            layer.open({            //layer提供了5种层类型。可传入的值有：0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）
                                type:1,
                                title:"查看详情",
                                area: ['50%','50%'],
                                content:$("#view").html()
                            });

                        } else {
                            //JSON.stringify(data.field)
                            layer.alert(data.message, {
                                title: '失败信息'
                            });
                        }

                    },
                    error:function(data){

                    }
                });


            } else {
                if (layEvent === 'del') { //删除
                    layer.confirm('是否删除这一条信息？', function (index) {
                        obj.del(); //删除对应行（tr）的DOM结构，并更新缓存
                        layer.close(index);
                        //向服务端发送删除指令
                        $.ajax({
                            type: 'get',
                            url: '/job/delete?id=' + data.id ,//请求数据的地址

                            success: function (data) {
                                data = JSON.parse(data);
                                if ( data.status == 'success') {

                                } else {
                                    //JSON.stringify(data.field)
                                    layer.alert(data.message, {
                                        title: '失败信息'
                                    });
                                }

                            },
                            error:function(data){

                            }
                        });

                    });
                } else if (layEvent === 'edit') { //编辑

                    $.ajax({
                        type: 'get',
                        url: '/job/view?id=' + data.id ,//请求数据的地址

                        success: function (data) {
                            data = JSON.parse(data);
                            if ( data.status == 'success') {
                                info = data.data;

                                $("#eidt_view_type").val(info.type);
                                $("#edit_job_name").val(info.job_name);
                                $("#edit_link_man").val(info.link_man);
                                $("#edit_link_phone").val(info.link_phone);
                                $("#edit_link_email").val(info.link_email);
                                $("#edit_view_place").val(info.place);
                                $("#edit_view_note").val(info.note);
                                // $("#view_need_count").val(info.need_count);
                                $("#edit_need_height").val(info.need_height);
                                $("#edit_meeting_time").val(info.meeting_time);
                                $("#edit_start_date").val(info.start_date);
                                $("#edit_end_date").val(info.end_date);
                                $("#edit_salary").val(info.salary);
                                $("#edit_create_time").val(info.create_time);


                                //do something
                                layer.open({            //layer提供了5种层类型。可传入的值有：0（信息框，默认）1（页面层）2（iframe层）3（加载层）4（tips层）
                                    type: 1,
                                    title: "修改信息",
                                    area: ['70%', '70%'],
                                    content: $("#edit").removeClass('layui-hide'),
                                    // success: layui.use('laydate', function() {
                                    //     var laydate = layui.laydate;
                                    //
                                    //         //日期
                                    //         laydate.render({
                                    //             elem: '#start_date'
                                    //         });
                                    // })
                                    end:function(){
                                        $("#edit").addClass('layui-hide')
                                    }
                                });

                            } else {
                                //JSON.stringify(data.field)
                                layer.alert(data.message, {
                                    title: '失败信息'
                                });
                            }

                        },
                        error:function(data){

                        }
                    });




                    //同步更新缓存对应的值
                    obj.update({
                        job_name: '123'
                        , meeting_time: 'xxx'
                    });
                }
            }
        });

        laydate.render({
            elem: '#start_date'
        });
        laydate.render({
            elem: '#end_date'
        });

        laydate.render({
            elem: '#meeting_time',
            type: 'datetime'
        });

        //创建一个编辑器
        var editIndex = layedit.build('LAY_demo_editor');

        //自定义验证规则
        form.verify({
            title: function(value){
                if(value.length < 1){
                    return '必填项不能为空';
                }
            }
            ,pass: [/(.+){6,12}$/, '密码必须6到12位']
            ,date: [/(.+){6,20}$/, '集合时间格式不正确']
            ,content: function(value){
                layedit.sync(editIndex);
            }
        });

        //监听提交
        form.on('submit(demo1)', function(data){

            console.log(data.field);


            $.ajax({
                type: 'post',
                url: '/job/save?id=' + data.field.id,//请求数据的地址
                data: data.field,
                success: function (data) {
                    data = JSON.parse(data);
                    if (data.status == 'success') {
                        layer.alert('修改成功');

                    } else {
                        //JSON.stringify(data.field)
                        layer.alert(data.message, {
                            title: '失败信息'
                        });
                    }

                },
                error:function(data){

                }
            });


            return false;
        });



        // 刷新
        $('#btn-refresh').on('click', function () {
            tableIns.reload();
        });

        // you code ...

    });





</script>
<!-- 表格操作按钮集 -->
<script type="text/html" id="barOption">
    <a class="layui-btn layui-btn-mini" lay-event="detail">查看</a>
    <a class="layui-btn layui-btn-mini layui-btn-normal"  lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-mini layui-btn-danger" lay-event="del">删除</a>
</script>
</body>
</html>