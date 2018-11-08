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
    <title>表单</title>
    <link rel="stylesheet" href="/layui/frame/layui/css/layui.css">
    <link rel="stylesheet" href="/layui/frame/static/css/style.css">
    <link rel="icon" href="/layui/frame/static/image/code.png">
</head>
<body class="body">


<blockquote class="layui-elem-quote layui-text">
    发布职位
</blockquote>

<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
    <legend>请填写相关信息</legend>
</fieldset>

<form class="layui-form" action="">

    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label">兼职名称</label>
            <div class="layui-input-block" style="width:500px">
                <input type="text"  name="job_name" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
            </div>
        </div>



        <div class="layui-inline">
            <label class="layui-form-label">类型</label>
            <div class="layui-input-inline">
                <select name="type" lay-verify="required" lay-search="">

                    <option value="1">暑假实践</option>
                    <option value="2">寒假实践</option>
                    <option value="3" selected>普通兼职</option>
                    <option value="4">全职</option>
                </select>
            </div>
        </div>
    </div>


    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label">工作开始日期</label>
            <div class="layui-input-inline">
                <input type="text" name="start_date" id="start_date" lay-verify="date" placeholder="yyyy-MM-dd" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-inline">
            <label class="layui-form-label">工作结束日期</label>
            <div class="layui-input-inline">
                <input type="text" name="end_date" id="end_date" lay-verify="date" placeholder="yyyy-MM-dd" autocomplete="off" class="layui-input">
            </div>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">所在地点</label>
        <div class="layui-input-inline">
            <select name="district">
                江岸、江汉、硚口、汉阳、武昌、青山、洪山   蔡甸、江夏、黄陂、新洲、东西湖、汉南
                <option value="武昌区" selected>武昌区</option>
                <option value="汉阳区">汉阳区</option>
                <option value="汉口区">汉口区</option>
                <option value="江岸区">江岸区</option>
                <option value="江汉区">江汉区</option>
                <option value="硚口区">硚口区</option>
                <option value="汉阳区">汉阳区</option>
                <option value="青山区">青山区</option>
                <option value="洪山区">洪山区</option>
                <option value="蔡甸区">蔡甸区</option>
                <option value="江夏区">江夏区</option>
                <option value="黄陂区">黄陂区</option>
                <option value="新洲区">新洲区</option>
                <option value="东西湖区">东西湖区</option>
                <option value="汉南区">汉南区</option>
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">具体地址</label>
        <div class="layui-input-block">
            <input type="text" name="place" lay-verify="title" autocomplete="off" placeholder="请输入具体地址" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label">集合时间</label>
            <div class="layui-input-inline">
                <input type="text" name="meeting_time" id="meeting_time" lay-verify="datetime" placeholder="yyyy-MM-dd HH:ii:ss" autocomplete="off" class="layui-input">
            </div>
        </div>

    </div>
    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label">工资</label>
            <div class="layui-input-inline" style="width: 100px;">
                <input type="number" name="salary_day" lay-verify="number" placeholder="￥" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-input-inline" style="width: 100px;">
                元/天
            </div>

            <div class="layui-input-inline" style="width: 100px;">
                <input type="number" name="salary_hour" lay-verify="number" placeholder="￥" autocomplete="off" class="layui-input" value="0">
            </div>
            <div class="layui-input-inline" style="width: 100px;">
                元/小时
            </div>


        </div>
<!--        <div class="layui-input-block">-->
<!--            <input type="text" name="note" lay-verify="title" autocomplete="off" placeholder="额外说明" class="layui-input">-->
<!--        </div>-->

    </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label">联系人</label>
            <div class="layui-input-inline">
                <input type="tel" name="link_man" lay-verify="title" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-inline">
            <label class="layui-form-label">联系手机号</label>
            <div class="layui-input-inline">
                <input type="tel" name="link_phone" lay-verify="phone" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-inline">
            <label class="layui-form-label">联系邮箱</label>
            <div class="layui-input-inline">
                <input type="text" name="link_email" lay-verify="email" autocomplete="off" class="layui-input">
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
                <input type="number" name="need_height" value="160" placeholder="160" autocomplete="off" class="layui-input">

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
<!-- 通用-970*90 -->
<div>
    <ins class="adsbygoogle" style="display:inline-block;width:970px;height:90px" data-ad-client="ca-pub-6111334333458862" data-ad-slot="6835627838"></ins>
</div>

<script src="/layui/frame/layui/layui.js" charset="utf-8"></script>
<script>
    layui.use(['form', 'layedit', 'laydate'], function(){
        var form = layui.form
            ,layer = layui.layer
            ,layedit = layui.layedit
            ,laydate = layui.laydate
            ,$ = layui.jquery;

        //日期
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

        //监听指定开关
        form.on('switch(switchTest)', function(data){
            layer.msg('开关checked：'+ (this.checked ? 'true' : 'false'), {
                offset: '6px'
            });
            layer.tips('温馨提示：请注意开关状态的文字可以随意定义，而不仅仅是ON|OFF', data.othis)
        });

        //监听提交
        form.on('submit(demo1)', function(data){

            console.log(data.field)


            $.ajax({
                type: 'post',
                url: '/job/save',//请求数据的地址
                data: data.field,
                success: function (data) {
                    data = JSON.parse(data);
                    if (data.status == 'success') {
                        layer.alert('添加成功');

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


    });
</script>
</body>
</html>
