
//根据条件查询列表
var listParam = { "page":1 ,
		            "pageNum":15}

function getListByParam($channeltype){
	$.post("/Sysmvpinfo/getListByParam/"+$channeltype,
			listParam,
		   function(data){
				$("#newsListTbody").empty();
				var dataArr = data.dataArr;

				for(var i = 0 , len = dataArr.length ; i < len ; i++){
					if ($channeltype==1) {
						var button = "    <a href=\"/Sysmvpservice/listView/"+dataArr[i].uid+"\"><button type=\"button\" class=\"btn btn-success btn-sm\" >服务管理</button></a> "+
													"    <a href=\"/Sysmvpprod/listView/"+dataArr[i].mid+"/"+dataArr[i].uid+"\"><button type=\"button\" class=\"btn btn-success btn-sm\" >作品管理</button></a> ";
					}else{
						var button= "<button type=\"button\" class=\"btn btn-success btn-sm\" onclick=\"changeStatus("+dataArr[i].uid+",1)\" >审核通过</button> <button type=\"button\" class=\"btn btn-warning btn-sm\" onclick=\"changeStatus("+dataArr[i].uid+",2)\" >审核未通过</button>";
					}
					$("#newsListTbody").append(" <tr> "+
							                    "   <td>"+dataArr[i].uid+"</td> "+
												"    <td >"+dataArr[i].email+"</td> "+
												"    <td >"+dataArr[i].tel_num+"</td> "+
												"  <td>"+dataArr[i].name+"</td> "+
												"  <td>"+dataArr[i].mvp_status+"</td> "+
												"  <td>	<a href=\"/Sysmvpinfo/updateView/"+dataArr[i].mid+"\"><button type=\"button\" class=\"btn btn-success btn-sm\" >修改</button></a> "+ button +
												
												" </td> "+
												" </tr>");
				}
				//删除按钮
				/*" 		 <button type=\"button\" class=\"btn btn-danger btn-sm\" onclick=\"deleteData("+dataArr[i].mid+" ,"+dataArr[i].uid+")\">删除</button> "+*/
				  var pageInfo = data.pageInfoArr;
				  
				  var recordNum = parseInt(pageInfo.dataCount);                           //总条数
				  var pageNum = parseInt(pageInfo.pageCount);                            //总页数
				  var curPage = parseInt(pageInfo.page);                            //当前页
				  
				  //当没有数据或只有一页数据时,不显示分页
				  $(".pagination").empty();
				  if(pageNum != 0 && pageNum != 1){
					  var pageHtml = "<li><a href=\"#\" aria-label=\"Previous\" onclick=\"changPage("+ (curPage > 0?(curPage -1):1)+","+$channeltype+");\"><span aria-hidden=\"true\">&laquo;</span> </a> </li>";
					  pageHtml += " <li "+ (curPage==1?"class='active'":"") +"><a href=\"#\" onclick=\"changPage(1,"+$channeltype+");\">1</a></li>";
					  pageHtml += curPage - 2 > 2 ? "<li><a href=\"#\">...</a></li>":"";
					  for(var i = curPage - 2 ; i <= curPage+2 ; i++){
						  if(i < 2 || i >= pageNum){
							  continue ; 
						  }
						  pageHtml += " <li "+ (i==curPage?"class='active'":"") +"><a href=\"#\" onclick=\"changPage("+ i+","+$channeltype+");\">"+ i +"</a></li>";
						  
					  }
					  pageHtml += curPage+2 < pageNum-1 ? "<li><a href=\"#\">...</a></li>":"";
					  pageHtml += " <li "+ (pageNum==curPage?"class='active'":"") +"><a href=\"#\" onclick=\"changPage("+ pageNum+","+$channeltype+");\">"+pageNum+ "</a></li>";
					  pageHtml += "<li><a href=\"#\" aria-label=\"Next\" onclick=\"changPage("+ ((curPage + 1)<= pageNum ?(curPage + 1) :pageNum )+","+$channeltype+");\"><span aria-hidden=\"true\">&raquo;</span></a></li>";
					  
					  $(".pagination").append(pageHtml);
				  }

				  
	       },
	       "json"
	);
}
//翻页
function changPage(page,channeltype){
	listParam.page = page;
	getListByParam(channeltype);
}

function changeStatus(uid,type){
	if (type == 1) {

		var flag = window.confirm("确定让其成为MVP么？");
		if(flag == false ){
			return ;
		}
	}else if(type == 2){

		var flag = window.confirm("确定拒绝让其成为MVP么？");
		if(flag == false ){
			return ;
		}
	}
		$.post("/Sysmvpinfo/changeStatus",
			{'uid' : uid,'type':type},
			function(data){
				alert("成功修改");
				window.location.reload();
			},"json");
}

//课程类型选择
function changeCitySel(obj){
	var oneLevIndex = parseInt($(obj).find("option:selected").attr('oneLevIndex'));
	var oneLevObj =  cityArr[oneLevIndex];
	var twoLevArr = oneLevObj.childContArr ;
    var twoLevhtml = "" ;
    for(var i = 0 , len = twoLevArr.length; i < len ; i++ ){
	     var posTypeTwoLev = twoLevArr[i];
	     twoLevhtml += "<option  value=\""+posTypeTwoLev.id+"\"  >"+posTypeTwoLev.content+"</option>";
	 }
    $(obj).next().html(twoLevhtml);
}

//专业类型选择
function changeProfSel(obj){
	var oneLevIndex = parseInt($(obj).find("option:selected").attr('oneLevIndex'));
	var oneLevObj =  profArr[oneLevIndex];
	var twoLevArr = oneLevObj.childContArr ;
    var twoLevhtml = "" ;
    for(var i = 0 , len = twoLevArr.length; i < len ; i++ ){
	     var posTypeTwoLev = twoLevArr[i];
	     twoLevhtml += "<option  value=\""+posTypeTwoLev.id+"\"  >"+posTypeTwoLev.content+"</option>";
	 }
    $(obj).next().html(twoLevhtml);
}
function changeProVal(obj) {
	$(".profession").val($(obj).val());
	$(".profession0").val($(obj).find("option:selected").html());
}
function changeCityVal(obj) {
	$(".city").val($(obj).val());
	$(".city0").val($(obj).find("option:selected").html());
}

//添加和修改的数据验证
function upCheck(){
	var uId = $("#uId").val();
	var name = $("#name").val();
	var email = $("#email").val();
	var tel_num = $("#tel_num").val();
	var edit = $(".edit").val();
	if(name.replace(/\s+/g,"") == ""){
		alert("姓名不能为空");
		return false ;
	}
	var description = $("#description").val();
	if(description.replace(/\s+/g,"") == ""){
		alert("介绍不能为空");
		return false ;
	}

	var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/; 
	var reg_1 = /^(0|86|17951)?(13[0-9]|17[0-9]|15[012356789]|18[0-9]|14[57])[0-9]{8}$/;
	
	//如果是个人用户则可以为邮箱或手机号,如果是HR用户则只能是邮箱

	if(!reg.test(email)){
		alert("邮箱格式不正确");
		return false ;
	}
	if(!reg_1.test(tel_num)){
		alert("手机号格式不正确");
		return false ;
	}
	//console.log(uId+name+email+tel_num+edit);

	$.post("/Sysmvpinfo/validation",{'email' : email,"tel_num":tel_num,"edit":edit,"uId":uId},
		function(data){
			if (data.status==0) {
				alert(data.info);
			}
		},"json");
	return true;
}

//删
function deleteData(mId , uId){
	var flag = window.confirm("确定删除么？");
	if(flag == false ){
		return ;
	}
	$.post("/Sysmvpinfo/delete",
			   {"mid" : mId ,"uid" : uId},
			   function(data){
					getListByParam();
			   },
			   "json"
			   );
}

//预览广告
function previewAdvert(adId){
	$('#previewAdvertModel').find("iframe").attr("src" , "/sysadvert/preview/"+adId);
	
	$('#previewAdvertModel').modal();
}

//上传标题图片
function updateTitPic(obj){
	var id = $(obj).attr('id');
	$.ajaxFileUpload
	(
		{
			url:'/Sysmvpinfo/upTitPic', 
			secureuri:false,
			fileElementId:id,
			dataType: 'json',
			success: function (data, status)
			{
				if(data.error){
					alert(data.error);
					return ;
				}
			     $("#"+id+"ShowImg").attr('src',data.thumbImgName);
			     $("#"+id+"Input").val(data.imgName);
			},
			error: function (data, status, e)
			{
				alert(e);
			}
		}
	)
}
