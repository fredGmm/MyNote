<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>原图管理</title>
    <link rel="stylesheet" href="/layui/frame/layui/css/layui.css">
    <!--<link rel="stylesheet" href="http://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">-->
    <link rel="stylesheet" href="/layui/frame/static/css/style.css">
    <link rel="icon" href="/layui/frame/static/image/code.png">
</head>
<body class="body">
<form class="layui-form layui-hide" id="edit" action="">

    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label">商品ID:</label>
            <div class="layui-input-inline" style="width: 100px;">
                <label class="layui-form-label" id="item_id"></label>
<!--                <div class="layui-form-mid layui-word-aux" id="item_id"></div>-->
            </div>
        </div>


    </div>

    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label">商品名称</label>
            <div class="layui-input-block" style="width:500px">
                <input type="text" id="edit_item_name"  name="item_name" lay-verify="required" placeholder="请输入" autocomplete="off" class="layui-input">
            </div>
        </div>


    </div>



    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label">价格</label>
            <div class="layui-input-inline" style="width: 100px;">
                <input type="number" id="edit_price" name="edit_price" lay-verify="number" placeholder="￥" autocomplete="off" class="layui-input">
            </div>
            <a class="layui-btn layui-btn-mini layui-btn-warm" style="margin-top: 5px;margin-left:5px;">cc</a>

        </div>
        <div class="layui-input-block">
            <input type="text" id="edit_describe" name="edit_describe" lay-verify="title" autocomplete="off" placeholder="额外说明" class="layui-input">
        </div>

    </div>

    <div class="layui-form-item">
        <div class="layui-inline">
            <label class="layui-form-label">库存</label>
            <div class="layui-input-inline" style="width: 100px;">
                <input type="number" id="edit_sku_count" name="edit_sku_count" value="100" placeholder="100" autocomplete="off" class="layui-input">

            </div>
            <!-- <div class="layui-form-mid layui-word-aux">以上</div> -->
<!--            <div class="layui-inline layui-word-aux"><label class="layui-form-label">cm以上</label></div>-->

        </div>

    </div>

    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</form>
<!-- 工具集 -->
<div class="my-btn-box">
            <span class="fl">
                <a class="layui-btn layui-btn-danger radius btn-delect" id="btn-delete-all">批量删除</a>
                <button type="button" class="layui-btn" id="test1"><i class="layui-icon">&#xe67c;</i>上传商品</button>
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

<?php foreach ($imgs as $item): ?>
    <div class="layui-box layui-inline " style="margin-top:20px; margin-left:20px;border: 0px solid  ">

<!--      <img id="itemImg" style="width:200px;height:200px" src="--><?php //echo  'https://images.weserv.nl/?url=' . $item['url'] ?? ''; ?><!--">-->
<!--      <img id="itemImg" style="width:200px;height:200px" referrerPolicy="no-referrer" src="--><?php //echo   $item['url'] ?? ''; ?><!--">-->
      <img id="itemImg" style="width:200px;height:200px" referrerPolicy="no-referrer" src="<?php echo  'https://images.weserv.nl/?url=' . $item['url'] ?? ''; ?>">
      <div style="margin: 5px auto">
          <a class="layui-btn layui-btn-mini view" target="_blank" referrerPolicy="no-referrer" href="<?php echo str_replace("http:", 'https:', $item['url']); ?>" dataid=<?php echo $item['id']; ?>">查看</a>

          <a class="layui-btn layui-btn-mini layui-btn-normal edit" >编辑</a>
          <a class="layui-btn layui-btn-mini layui-btn-danger delete" >删除</a>
          <a class="layui-btn layui-btn-mini layui-btn-warm" todb">入库</a>

      </div>
      <!--这里我们假如图片的实际尺寸是320X320-->
    </div>
<?php endforeach; ?>




   <!-- 需要弹出的添加员工界面 -->
        <div class="layui-row layui-form" id="item_info" style="display: none;">
           <div class="layui-form-item">
               <label class="layui-form-label">输入框</label>
               <div class="layui-input-block">
                 <input type="text" name="" placeholder="请输入" autocomplete="off" class="layui-input">
               </div>
           </div>

           <div class="layui-form-item">
    <div class="layui-input-block">
      <button class="layui-btn" lay-submit lay-filter="go">立即提交</button>
      <button type="reset" class="layui-btn layui-btn-primary">重置</button>
    </div>
  </div>
        </div>

    
  <script src="/layui/frame/layui/layui.js"></script>
  <script>
  layui.use(['upload','form'], function(){
    var upload = layui.upload;
    var $ = layui.jquery;
    var form = layui.form;
    //执行实例
    var uploadInst = upload.render({
      elem: '#test1' //绑定元素
      ,url: '/upload/image' //上传接口
      ,done: function(res){
        //上传完毕回调

            layer.open({
                title: '提示信息'
                ,content: '上传成功！'
            });
            window.location.reload();
      }
      ,error: function(){
        //请求异常回调
        // layui.msg('ewq');
        $("#itemImg").attr('src','../images/w.jpg'); 
      }
    });

    $(".view").click(function(){

        // var item_id = $(this).attr("dataid");
        // var url = $(this).attr("href");
        //
        // layer.open({
        //                 type:1,
        //                 title:"查看详情",
        //                 skin:"myclass",
        //                  area:["50%","50%"],
        //                 content:"<img id=\"itemImg\"  referrerPolicy=\"no-referrer\" src=\""+ url +"\">"
        //             });

      });

      $(".edit").click(function(){
          // alert($(this).attr("dataid"));
          var item_id = $(this).attr("dataid");
          $("#item_id").html(item_id);
          layer.open({
              type:1,
              title:"查看详情",

              area:["50%","80%"],
              content:$("#edit").removeClass('layui-hide'),
              end:function(){
                  $("#edit").addClass('layui-hide')
              }
          });

      });

      $(".delete").click(function(){
          // alert($(this).attr("dataid"));
          var item_id = $(this).attr("dataid");

          layer.open({
              content: '确认删除吗？',
              btn: ['确认', '取消'],
              yes: function(index, layero){
                  //do something
                  alert(item_id);
                  layer.close(index); //如果设定了yes回调，需进行手工关闭
              },
              btn2: function(index, layero){
                  return false;
              }
          });

      });

      $(".todb").click(function)(){

      }
      // 刷新
      $('#btn-refresh').on('click', function () {
          window.location.reload();
      });

      form.on('submit(go)', function(data){
          console.log(data.elem); //被执行事件的元素DOM对象，一般为button对象
          console.log(data.form); //被执行提交的form对象，一般在存在form标签时才会返回
          console.log(data.field); //当前容器的全部表单字段，名值对形式：{name: value}
          alert(32423423);
          return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
    });

    });

    

    
  </script>
  </body>
  </html>