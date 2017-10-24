
//根据条件查询广告列表
var advertParam = {"advertType" : 0 , "advertNameKeyWord" : ""}
function getAdvertByParam(){
	advertParam.advertType = $("#advertTypeSelect").val();
	advertParam.advertNameKeyWord = $("#advertNameKeyWordInput").val();

	$.post("/sysadvert/getAdvertByParam",
		   advertParam,
		   function(data){
				if(data.error == "relogin"){
					alert("请重新登录！");
					return ;
				}
				$("#advertListTbody").empty();

				var advertTimeLimitObj = {"0" :"不限制" , "1":"设定时间限制"};
				for(var i = 0 , len = data.length ; i < len ; i++){
					var timeLimitIndex = data[i].time_limit;
					var timeEnd = data[i].time_end.substr(0 , 10);
					$("#advertListTbody").append("<tr> "+
									              "    <td class='advertIdTds' >" +data[i].id+ "</td> "+
									              "    <td>" +data[i].name+ "</td>"+
									              "    <td>" +data[i].type+ "</td>"+
									              "    <td>" +advertTimeLimitObj[timeLimitIndex]+ "</td>"+
									              "    <td>" +timeEnd+ "</td>"+
									              "    <td><input style=\"width:100px\" class=\"form-contro advertOrdNums\" value=\"" +data[i].order_num+ "\" /></td>"+
									              "    <td>"+
									               "      <a href=\"/sysadvert/upAdvertView/"+data[i].id+"\"><button type=\"button\" class=\"btn btn-success btn-sm\" >修改</button></a>"+
									              "       <button type=\"button\" class=\"btn btn-info btn-sm\" onclick=\"previewAdvert(" +data[i].id+ ")\">预览</button>"+
									              "       <button type=\"button\" class=\"btn btn-danger btn-sm\" onclick=\"deleteAdvert(" +data[i].id+ ")\">删除</button>"+
									              "    </td> "+
									              "  </tr>");
				}
	       },
	       "json"
	);
}
//添加广告的数据验证
function advertCheck(){
	var adName = $("#adName").val();
	if(adName.replace(/\s+/g,"") == ""){
		alert("广告名称不能为空");
		return false ;
	}
	var adNmCont = $("#adNmCont").val();
	if(adNmCont.replace(/\s+/g,"") == ""){
		alert("广告显示内容不能为空");
		return false ;
	}
}

//修改排序
function updateOrderNums(){
	var advertIdTds = "" ;
	$(".advertIdTds").each(function(i){
		if(i == 0 ){
			advertIdTds += $(this).text();
		}else {
			advertIdTds += "|"+$(this).text();
		}
		
	});
	var advertOrdNums = "" ;
	$(".advertOrdNums").each(function(i){
		if(i == 0 ){
			advertOrdNums += $(this).val();
		}else {
			advertOrdNums += "|"+$(this).val();
		}
	});

	var param = {ids:advertIdTds , ordnums:advertOrdNums};
	$.post("/sysadvert/updateOrderNums",
			param , 
			function(data){
				if(data.error){
					alert(data.error);
					return ;
				}

		        getAdvertByParam();
	         },
	         "json"
		   );
}


//删除广告
function deleteAdvert(adId){
	var flag = window.confirm("确定删除广告么？");
	if(flag == false ){
		return ;
	}
	$.post("/sysadvert/deleteAdvert",
			   {"adId" : adId},
			   function(data){
					if(data == "relogin"){
						alert("请重新登录！");
						return ;
					}
					getAdvertByParam();
			   },
			   "json"
			   );
}

//预览广告
function previewAdvert(adId){
	$('#previewAdvertModel').find("iframe").attr("src" , "/sysadvert/preview/"+adId);
	
	$('#previewAdvertModel').modal();
}

//上传广告图片
function updateAdvertPic(){
	$.ajaxFileUpload
	(
		{
			url:'/sysadvert/getAdvertPic', 
			secureuri:false,
			fileElementId:'advertImgFile',
			dataType: 'json',
			success: function (data, status)
			{
				if(data.error){
					alert(data.error);
					return ;
				}
			     $("#advertImg").attr('src','/uploads/manager/advert/'+data.imgName);
			     $("#advertImgThumb").attr('src','/uploads/manager/advert/'+data.thumbImgName);
			     $("#advertImgInput").val(data.imgName);
			     $("#advertImgThumbInput").val(data.thumbImgName);
			     $("#advertImgSpan").text('/uploads/manager/advert/'+data.imgName);
			     $("#advertImgThumbSpan").text('/uploads/manager/advert/'+data.thumbImgName);
			},
			error: function (data, status, e)
			{
				alert(e);
			}
		}
	)
}