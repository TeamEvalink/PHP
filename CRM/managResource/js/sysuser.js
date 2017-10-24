
var advertParam = {"advertNameKeyWord" : ""}
function getActiveByParam(page,page_totle,per_page){


	//advertParam.starType = $("#star").val();
	//advertParam.advertNameKeyWord = $("#advertNameKeyWordInput").val();

	//alert(advertParam.advertNameKeyWord);

	$.post("/sysuser/getActiveByParam/"+page+'/'+page_totle+'/'+per_page,

		
		   advertParam,
		   function(data){
				if(data.error == "relogin"){
					alert("请重新登录！");
					return ;
				}

				//alert(data[0].u_group_id);
				$("#advertListTbody").empty();

				
				for(var i = 0 , len = data.length ; i < len ; i++){

					if(data[i].is_ban == 1){
						data[i].is_ban = '启用';
					}else{
						data[i].is_ban = "未启用";
					}

					//alert(i);
					/*var typeIndex = data[i].type;
					var timeLimitIndex = data[i].time_limit;*/
					//var timeEnd = data[i].time_end.substr(0 , 10);
					$("#advertListTbody").append("<tr> "+
									              "    <td>" +data[i].id+ "</td> "+
									              "    <td>" +data[i].account+ "</td>"+
									              "    <td>" +data[i].user_name+ "</td>"+
									              "    <td>" +data[i].group+ "</td>"+
									              //"    <td>" +data[i].content.substring(0,20)+ "...</td>"+
									              "    <td>" +data[i].last_log_time+ "</td>"+
									              "    <td>" +data[i].last_log_ip+ "</td>"+
									              "    <td>" +data[i].is_ban+ "</td>"+
									              "    <td>"+
									               "      <button type=\"button\" class=\"btn btn-success btn-sm\" onclick=\"act_update(" +data[i].id+ ")\">修改</button>"+
									              
									              "       <button type=\"button\" class=\"btn btn-danger btn-sm\" onclick=\"deleteAdvert(" +data[i].id+ ")\">删除</button>"+
									              "    </td> "+
									              "  </tr>");
				}
	       },
	       "json"
	);
}

//根据ID获取唯一一个广告，用于填充修改广告的模态对话框

//删除活动
function deleteAdvert(adId){
	var flag = window.confirm("确定删除么？");
	if(flag == false ){
		return ;
	}
	//Ajax
                $.ajax({
                    url: '/sysuser/deleteActive',
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
                        window.location.href="/sysuser"; 
                    }
                });
      //Ajax end
}
function updateuser(id){
	$.post("/sysuser/Act_update", $("#useredit").serialize(),
			function (data){
				//console.log(data);
				if(data == 'relogin'){
					alert("请重新登录！");
					return ;
				}
				alert(data);
				window.location.href="/sysuser";
	        },
	        "text"
			);
}

function adduser(){
	
	$.post("/sysuser/addActive", $("#useredit").serialize(),function(data){
			if (data.status==0) {
				alert(data.info);
				return ;
			}
			if (data.status==1) {
				alert(data.info);
				window.location.href="/sysuser";
			}

		},'json');
}
//管理員修改
function act_update(adId){
	
	location.href="/sysuser/update/"+adId;
}
function checkAll(o){
	if( o.checked == true ){
		$('input[name="checkbox"]').attr('checked','true');
		$('tr[overstyle="on"]').addClass("bg_on");
	}else{
		$('input[name="checkbox"]').removeAttr('checked');
		$('tr[overstyle="on"]').removeClass("bg_on");
	}
}