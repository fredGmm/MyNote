layui.config({
	base : "js/"
}).use(['form','layer','jquery','layedit','laydate'],function(){
	var form = layui.form(),
		layer = parent.layer === undefined ? layui.layer : parent.layer,
		laypage = layui.laypage,
		layedit = layui.layedit,
		laydate = layui.laydate,
		$ = layui.jquery;

	//创建一个编辑器
 	var editIndex = layedit.build('news_content');
 	var addNewsArray = [],addNews;
 	// form.on("submit(addNews)",function(data){
 	// 	//是否添加过信息
	 // 	if(window.sessionStorage.getItem("addNews")){
	 // 		addNewsArray = JSON.parse(window.sessionStorage.getItem("addNews"));
	 // 	}
	 // 	//显示、审核状态
 	// 	var isShow = data.field.show=="on" ? "checked" : "",
 	// 		newsStatus = data.field.shenhe=="on" ? "审核通过" : "待审核";
     //
 	// 	addNews = '{"newsName":"'+$(".newsName").val()+'",';  //文章名称
 	// 	addNews += '"newsId":"'+new Date().getTime()+'",';	 //文章id
 	// 	addNews += '"newsLook":"'+$(".newsLook option").eq($(".newsLook").val()).text()+'",'; //开放浏览
 	// 	addNews += '"newsTime":"'+$(".newsTime").val()+'",'; //发布时间
 	// 	addNews += '"newsAuthor":"'+$(".newsAuthor").val()+'",'; //文章作者
 	// 	addNews += '"isShow":"'+ isShow +'",';  //是否展示
 	// 	addNews += '"newsStatus":"'+ newsStatus +'"}'; //审核状态
 	// 	addNewsArray.unshift(JSON.parse(addNews));
 	// 	window.sessionStorage.setItem("addNews",JSON.stringify(addNewsArray));
 	// 	//弹出loading
 	// 	var index = top.layer.msg('数据提交中，请稍候',{icon: 16,time:false,shade:0.8});
      //   setTimeout(function(){
      //       top.layer.close(index);
		// 	top.layer.msg("文章添加成功！");
 	// 		layer.closeAll("iframe");
	 // 		//刷新父页面
	 // 		parent.location.reload();
      //   },2000);
 	// 	return false;
 	// })

	var fit_type ;
	var _food = '';
	$("#food_add_btn").click(function(){
		event.preventDefault();
		fit_type = $("input[name='breakfast']").is(':checked') ? '1,' : '';
		fit_type += $("input[name='lunch']").is(':checked')? '2,' : '';
		fit_type += $("input[name='supper']").is(':checked')? '3' : '';

		_food += 'food_info[food_name]='+ $(".foodName").val();
		_food += '&food_info[fit_type]='+ fit_type;
		_food += '&food_info[description]='+ layedit.getContent(editIndex);
		_food += '&food_info[shop_name]=活子轩食府';
		_food += '&food_info[kind]=meat';
		
		$.ajax({
			type: 'POST',
			url:"/admin/food/add",
			dataType: 'json',
		//	data: {food_info:JSON.stringify(food_info)}, //直接传的json
			data : _food,
			success:function(result){
				if(result.code == 0){
					var index = top.layer.msg('数据提交中，请稍候',{icon: 16,time:false,});
					top.layer.close(index);
					top.layer.msg("添加成功！");
					layer.closeAll("iframe");
					//刷新父页面
					parent.location.reload();
				}else{
					layer.alert('添加失败', {
						skin: 'layui-layer-lan'
						,closeBtn: 0
						,anim: 1 //动画类型
					});
				}
			}

		});

	});

	return false;
})
