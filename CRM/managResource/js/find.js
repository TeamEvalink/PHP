
//根据条件查询广告列表
var advertParam = {"advertNameKeyWord" : ""}
function getActiveByParam(page,page_totle,per_page){


	//advertParam.starType = $("#star").val();
	advertParam.advertNameKeyWord = $("#advertNameKeyWordInput").val();

	//alert(advertParam.advertNameKeyWord);

	$.post("/find/getActiveByParam/"+page+'/'+page_totle+'/'+per_page,

		
		   advertParam,
		   function(data){

		   	console.log(data);
				if(data.error == "relogin"){
					alert("请重新登录！");
					return ;
				}
				//alert(data);
				$("#advertListTbody").empty();				
				for(var i = 0 , len = data.length ; i < len ; i++){

					if(data[i].is_show == 1){
						data[i].is_show = '显示';
					}else{
						data[i].is_show = "未显示";
					}

					if(data[i].kind == 1){
						data[i].kind = '线上';
					}else{
						data[i].kind = '线下';
					}

					//alert(i);
					var typeIndex = data[i].type;
					var timeLimitIndex = data[i].time_limit;
					//var timeEnd = data[i].time_end.substr(0 , 10);
					$("#advertListTbody").append("<tr> "+
									              "    <td>" +data[i].id+ "</td> "+
									              "    <td>" +data[i].title.substring(0,12)+ "..</td>"+
									              //"    <td>" +data[i].content.substring(0,20)+ "...</td>"+
									              "    <td>" +data[i].active_time+ "</td>"+
									              "    <td>" +data[i].address+ "</td>"+
												  "    <td>" +data[i].kind+ "</td>"+
									              "    <td>" +data[i].is_show+ "</td>"+
									              "    <td>"+
									               "      <button type=\"button\" class=\"btn btn-success btn-sm\" onclick=\"act_update(" +data[i].id+ ")\">修改</button>"+
									              "       <button type=\"button\" class=\"btn btn-info btn-sm\" onclick=\"detail_view(" +data[i].id+ ")\">预览</button>"+
									              "       <button type=\"button\" class=\"btn btn-danger btn-sm\" onclick=\"deleteAdvert(" +data[i].id+ ")\">删除</button>"+
									              "      <button type=\"button\" class=\"btn btn-success btn-sm\" onclick=\"baoming(" +data[i].id+ ")\">报名人员</button>"+
									              "       <button type=\"button\" class=\"btn btn-info btn-sm\" onclick=\"notice(" +data[i].id+ ")\">发送通知</button>"+
									              "       <button type=\"button\" class=\"btn btn-danger btn-sm\" onclick=\"analyse(" +data[i].id+ ")\">数据分析</button>"+
									              "    </td> "+
									              "  </tr>");
				}
	       },
	       "json"
	);
}


/**/

//根据ID获取唯一一个广告，用于填充修改广告的模态对话框

//删除活动
function deleteAdvert(adId){
	var flag = window.confirm("确定删除发现么？");
	if(flag == false ){
		return ;
	}
	//Ajax
                $.ajax({
                    url: '/find/deleteActive',
                    type: 'post',
                    data: {
                        'id': adId
                    },
                    success: function (data) {
                        //alert(data);

						if(data == 1){
							alert('删除成功');
						}else{
							alert('删除失败');
						}
                        location.href="/find";
                    }
                });
      //Ajax end
}

//活动详情
function previewAdvert(adId){
	$('#previewAdvertModel').find("iframe").attr("src" , "/find/preview/"+adId);

	//alert(adId);
	
	$('#previewAdvertModel').modal();
}

//报名人员

function baoming(adId){
	location.href="/find/find_apply/"+adId;
}

//活动详情预览
function detail_view(adId){
	//Ajax
               //location.href="/seekerfind/detail/".adId;

			   //location.href="/seekerfind/detail/"+adId;

			    window.open("/seekerfind/detail/"+adId);
      //Ajax end
	
}

//活动修改
function act_update(adId){
	
	location.href="/find/update/"+adId;
}

//发送通知
function notice(adId){
	
	location.href="/find/notice/"+adId;
}

//数据分析
function analyse(adId){
	
	location.href="/find/analyse/"+adId;
}