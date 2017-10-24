
//===========================================================联动类别管理页功能=================================
//更新联动类别名称
//id -- 联动类别ID
//obj -- 点击按钮对象
function updateCcdTypeName(id,obj){
	var typeName = $(obj).parent().parent().find("input").val();
	var param = {"id" :id , "typeName" : typeName};
	$.post("/cascade/updateCcdTypeName",
			param,
			function (data){
				//console.log(data);
				if(data == 'relogin'){
					alert("请重新登录！");
					return ;
				}
				alert("更新成功,修改了"+data+"条记录！");
				window.location.reload(true);
	        },
	        "text"
			);
}


//删除整个联动类型，包括类型名和所有子项内容
//typeId -- 联动类型ID
function deleteCcdType(typeId){
	var flag = window.confirm("该操作将删除联动类型和相关的所有子项内容  \n 确认删除吗？");
	if(flag == false ){
		return ;
	}
	var param = {"typeId" :typeId };
	$.post("/cascade/deleteCcd",
			param,
			function (data){
				//console.log(data);
				if(data == 'relogin'){
					alert("请重新登录！");
					return ;
				}
				alert("删除成功,删除的联动类型数及其内容数为: "+data + " !");
				window.location.reload(true);
	        },
	        "text"
			);
}

//更新联动内容缓存
function updateCcdCache(obj){
	$(obj).text('更新中...').attr('disabled' , 'disabled');
	$.post("/cascade/updateCcdCache",
			null,
			function (data){
		  		alert("更新成功 ,更新的缓存类别数 ： "+data.typeCount+ "  缓存所有内容数 ： " +data.contentCount);
		  		$(obj).text('更新缓存').removeAttr('disabled');
	        },
	        "json"
			);
}
//===========================================================联动类别管理页功能=================================



//===========================================================联动子项内容管理页功能=================================
//获取联动类型子项内容,用于联动子项内容的展示

var ccdContParam = {"typeId":null , "topId":null};
function getCcdCont(){
	
	if(ccdContParam.typeId == null || ccdContParam.topId == null){
		return ;
	}
	$.post("/cascade/getCcdCont",
			ccdContParam,
			function (data){
				//console.log(data);
				if(data.error == "relogin"){
					alert("请重新登录！");
					return ;
				}
				
				$("#ccdContTbody").empty();
				for(var i = 0 , len = data.length ; i < len ; i++){
					$("#ccdContTbody").append("<tr> "+
								              "    <td>"+
											  "		  <input type=\"checkbox\" id=\"inlineCheckbox1\" value=\""+data[i].id+"\">"+
											   "  </td> "+
								               "   <td>"+data[i].id+"</td> "+
								               "   <td><input type=\"text\" class=\"form-control input-sm\"  value=\""+data[i].content+"\" > </td>"+
								               "   <td><input type=\"text\" class=\"form-control input-sm\"  value=\""+data[i].order_num+"\" > </td>"+
								               "   <td>"+data[i].level+"级内容</td> "+
								               "   <td>"+
								               "      <button type=\"button\" class=\"btn btn-success btn-sm\" onclick=\"updateCcdCont("+data[i].id+" , this)\">更新</button>"+
								               "      <button type=\"button\" class=\"btn btn-danger btn-sm\" onclick=\"deleteCcdCont("+data[i].id+")\">删除</button>"+
								               "   </td>"+
								               " </tr>");
				}

	        },
	        "json"
			);
}

//当改变子项topId时触发的事件
function ccdTopIdOnchange(obj){
	ccdContParam.topId = $(obj).val();
	getCcdCont();
}


//添加当前选中的栏目的子项内容
function addCcdChild(){
	var content = $("#ccdChildContTa").val();
	if(content == "" ){
		alert("子项名称不能为空！");
		return 
	}

	var childCcdParam = {"typeId" : ccdContParam.typeId,
			             "topId" : ccdContParam.topId,
			             "content" : content
		                };

	$.post("/cascade/addChildContent",
			childCcdParam,
			function (data){
				//console.log(data);
				if(data == 'relogin'){
					alert("请重新登录！");
					return ;
				}
		        getCcdCont();
	        },
	        "text"
			);
}

//删除联动子级内容,包括其子级的内容，默认只有两级
function  deleteCcdCont(contentId){
	var flag = window.confirm("该操作将删除相关的所有子项内容  \n 确认删除吗？");
	if(flag == false ){
		return ;
	}
	$.post("/cascade/deleteCcdCont",
			{"contentId" : contentId},
			function (data){
				//console.log(data);
				if(data == 'relogin'){
					alert("请重新登录！");
					return ;
				}
			   getCcdCont();
			},
			"text"
			);
}


//更新子项内容
function updateCcdCont(contentId , obj){
	var inputObjArr = $(obj).parent().parent().find(".form-control");
    var content = inputObjArr[0].value;
	var orderNum = inputObjArr[1].value;
	if(content == "" ){
		alert("子项名称不能为空！");
		return 
	}
	if(orderNum == ""){
		orderNum == 0;
	}
	var childCcdParam = {"contentId" : contentId,
			             "content" : content,
			             "orderNum" : orderNum
		                };

	$.post("/cascade/updateCcdCont",
			childCcdParam,
			function (data){
				//console.log(data);
				if(data == 'relogin'){
					alert("请重新登录！");
					return ;
				}
				
				alert("成功更新"+data+"条记录!");
		        getCcdCont();
	        },
	        "text"
			);
}

//===========================================================联动子项内容管理页功能=================================