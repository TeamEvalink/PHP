

//==================================================================视频课程信息操作=============================================
//根据条件查询新闻列表
var vcParam = { "vcTypeOneLev" : 0 ,
		        "vcTypeTwoLev" : 0 , 
		        "vcstatus" : -1 ,
		            "page":1 ,
		            "pageNum":10,
		            "sortCln":'pub_date'}
function getVcByParam(){
	$.post("/sysVideoCourse/getVcByParam",
			vcParam,
		   function(data){
				$("#vcListTbody").empty();
				var dataArr = data.dataArr;
				var statusObj = {"0" : "否", "1":"是"};
				
				for(var i = 0 , len = dataArr.length ; i < len ; i++){

					var title = dataArr[i].course_name;
					title = title.length < 30 ?title : title.substr(0,30) + "...";
					var stsKey = dataArr[i].vc_status + "";
					var sts = statusObj[stsKey];
					var stsButton = "" ;
					if(dataArr[i].vc_status == 0){
						 stsButton = "<button type=\"button\" class=\"btn btn-success btn-sm\" onclick=\"updateVcSts("+dataArr[i].id+",1,"+dataArr[i].secNum+" );\">上线</button> ";
					}else {
						stsButton = "<button type=\"button\" class=\"btn btn-danger btn-sm\" onclick=\"updateVcSts("+dataArr[i].id+",0,"+dataArr[i].secNum+");\">下线</button> ";
					}
					
					$("#vcListTbody").append(" <tr> "+
							                    "   <td>"+dataArr[i].id+"</td> "+
												"    <td style='width:300px' >"+title+"</td> "+
												"    <td  >"+dataArr[i].vc_type_str+"</td> "+
												"  <td>"+dataArr[i].pub_date+"</td> "+
												"  <td>"+sts+"</td> "+
												"  <td>"+dataArr[i].price+"</td> "+
												"  <td>"+dataArr[i].order_num+"</td> "+
												"  <td>	" +
												     stsButton+
												"      <a target='_blank' href=\"/sysVideoCourse/updateView/"+dataArr[i].id+"\"><button type=\"button\" class=\"btn btn-success btn-sm\" >修改</button></a> "+
												" 		<a target='_blank'  href=\"/sysVideoCourse/vcSecList/"+dataArr[i].id+"\"><button type=\"button\" class=\"btn btn-info btn-sm\" >课程小节("+dataArr[i].secNum+")</button></a> "+
												" 		 <button type=\"button\" class=\"btn btn-danger btn-sm\" onclick=\"deleteVc("+dataArr[i].id+")\">删除</button> "+
												" </td> "+
												" </tr>");
				}
				
				  var pageInfo = data.pageInfoArr;
				  var recordNum = parseInt(pageInfo.dataCount);                           //总条数
				  var pageNum = parseInt(pageInfo.pageCount);                            //总页数
				  var curPage = parseInt(pageInfo.page);                            //当前页
				 // alert(recordNum + "--"+pageNum+"---"+curPage);
				  //当没有数据或只有一页数据时,不显示分页
				  $(".pagination").empty();
				  if(pageNum != 0 && pageNum != 1){
					  var pageHtml = "<li><a href=\"#\" aria-label=\"Previous\" onclick=\"changPage("+ (curPage > 0?(curPage -1):1)+");\"><span aria-hidden=\"true\">&laquo;</span> </a> </li>";
					  pageHtml += " <li "+ (curPage==1?"class='active'":"") +"><a href=\"#\" onclick=\"changPage(1);\">1</a></li>";
					  pageHtml += curPage - 2 > 2 ? "<li><a href=\"#\">...</a></li>":"";
					  for(var i = curPage - 2 ; i <= curPage+2 ; i++){
						  if(i < 2 || i >= pageNum){
							  continue ; 
						  }
						  pageHtml += " <li "+ (i==curPage?"class='active'":"") +"><a href=\"#\" onclick=\"changPage("+ i+");\">"+ i +"</a></li>";
						  
					  }
					  pageHtml += curPage+2 < pageNum-1 ? "<li><a href=\"#\">...</a></li>":"";
					  pageHtml += " <li "+ (pageNum==curPage?"class='active'":"") +"><a href=\"#\" onclick=\"changPage("+ pageNum+");\">"+pageNum+ "</a></li>";
					  pageHtml += "<li><a href=\"#\" aria-label=\"Next\" onclick=\"changPage("+ ((curPage + 1)<= pageNum ?(curPage + 1) :pageNum )+");\"><span aria-hidden=\"true\">&raquo;</span></a></li>";
					  
					  $(".pagination").append(pageHtml);
				  }

				  
	       },
	       "json"
	);
}
//翻页
function changPage(page){
	vcParam.page = page;
	getVcByParam();
}

//改变视频类型
function changeVcType(){
	vcParam.vcTypeOneLev = $("#vcTypeOneLev").val();
	vcParam.vcTypeTwoLev = $("#vcTypeTwoLev").val();
	vcParam.page = 1;
	getVcByParam();
}
//列表页课程类型选择
function listChangeVcTypeSel(obj){
	var oneLevIndex = parseInt($(obj).find("option:selected").attr('oneLevIndex'));
	var oneLevObj = null;
	var twoLevArr = [];
	//如果一级类型选了全部,则二级也只有全部
	if(oneLevIndex != -1){
		 oneLevObj =  vcTypeArr[oneLevIndex];
		 twoLevArr = oneLevObj.childContArr ;
	}
    var twoLevhtml = "" ;
    for(var i = 0 , len = twoLevArr.length; i < len ; i++ ){
	     var posTypeTwoLev = twoLevArr[i];
	     twoLevhtml += "<option  value=\""+posTypeTwoLev.id+"\"  >"+posTypeTwoLev.content+"</option>";
	 }
    twoLevhtml = "<option  value=\"0\"  >全部</option>"+twoLevhtml;
    $(obj).next().html(twoLevhtml);
}

//修改排序字段
function changeSortCln(sortCln){
	vcParam.sortCln = sortCln;
	vcParam.page = 1;
	getVcByParam();
}

//修改课程是否
function updateVcSts(vcId,sts, secNum){
	if(secNum == 0 && sts == 1){
		alert('该课程还没有视频,不能上线');
		return;
	}
	$.post("/sysVideoCourse/updateVcSts",
			   {"vcId" : vcId,
				"sts":sts
		       },
			   function(data){
		    	   getVcByParam();
			   },
			   "json"
			   );
	
}
//删除课程
function deleteVc(vcId){
	var flag = window.confirm('删除课程将删除课程和对应的课程小节,但不会删除腾讯云中的视频文件,确定删除么？');
	if(flag == false){
		return ;
	}
	$.post("/sysVideoCourse/deleteVc",
			   {"vcId" : vcId
		       },
			   function(data){
		    	   getVcByParam();
			   },
			   "json"
			   );
}
//-=================================================================视频课程新增页功能================================


//添加视频课程和修改视频课程的数据验证
function submitVcInfo(actionType){
	var vcTitImg = $("#vcTitImgInput").val();
	if(vcTitImg.replace(/\s+/g,"") == ""){
		alert("课程缩略图不能为空");
		return false ;
	}
	var newsTitle = $("#titleInput").val();
	if(newsTitle.replace(/\s+/g,"") == ""){
		alert("课程标题不能为空");
		return false ;
	}
	var keyWord = $("#keyWordInput").val();
	if(keyWord.replace(/\s+/g,"") == ""){
		alert("课程关键字不能为空");
		return false ;
	}
	var vcPrice = parseInt($("#vcPrice").val());
	if(vcPrice < 0 ){
			alert("课程价格不能为负数");
			return false ;
	}
	//拼接课程对应的多个职位类型
	var posTypeVal = $(".ptsol").eq(0).val()+"-"+$(".ptsol").eq(0).next().val();
	$(".ptsol").each(function(i){
		   if(i >= 1){
			   posTypeVal += "|" +$(this).val() +"-"+$(this).next().val();
		   }
	});
	$("#posTypeInput").val(posTypeVal);
	//拼接课程对应的多个职位类型
	var posTypeIds = $(".ptsol").eq(0).find("option:selected").attr('ccdKey')+
	                  "-"+
	                  $(".ptsol").eq(0).next().find("option:selected").attr('ccdKey');
	$(".ptsol").each(function(i){
		   if(i >= 1){
			   var posTypeId = $(this).find("option:selected").attr('ccdKey');
			   var posTypeIdNext = $(this).next().find("option:selected").attr('ccdKey');
			   posTypeIds += "|" +posTypeId +"-"+posTypeIdNext;
		   }
	});
	$("#posTypeIdsInput").val(posTypeIds);
	
	//赋值操作类型 ， 0--保存课程信息后跳转到列表页  ； 1--保存课程信息后跳转到课程小节添加页
	$("#actionTypeInput").val(actionType);
	return true;
}

//删除新闻
function deleteNews(nId){
	var flag = window.confirm("确定删除新闻么？");
	if(flag == false ){
		return ;
	}
	$.post("/sysnews/deleteNews",
			   {"newsId" : nId},
			   function(data){
					getNewsByParam();
			   },
			   "json"
			   );
}

//上传课程缩略图
function updateVcTitPic(){
	$.ajaxFileUpload
	(
		{
			url:'/sysVideoCourse/upVcTitPic', 
			secureuri:false,
			fileElementId:'vcImgFile',
			dataType: 'json',
			success: function (data, status)
			{
				if(data.error){
					alert(data.error);
					return ;
				}
			     $("#vcTitImg").attr('src','/uploads/manager/videoCourse/'+data.imgName);
			     $("#vcTitImgInput").val(data.imgName);
			},
			error: function (data, status, e)
			{
				alert(e);
			}
		}
	)
}
//课程类型选择
function changeVcTypeSel(obj){
	var oneLevIndex = parseInt($(obj).find("option:selected").attr('oneLevIndex'));
	var oneLevObj =  vcTypeArr[oneLevIndex];
	var twoLevArr = oneLevObj.childContArr ;
    var twoLevhtml = "" ;
    for(var i = 0 , len = twoLevArr.length; i < len ; i++ ){
	     var posTypeTwoLev = twoLevArr[i];
	     twoLevhtml += "<option  value=\""+posTypeTwoLev.id+"\"  >"+posTypeTwoLev.content+"</option>";
	 }
    $(obj).next().html(twoLevhtml);
}
//职位类型选择
function changePosTypeSel(obj){
	var oneLevIndex = parseInt($(obj).find("option:selected").attr('oneLevIndex'));
	var oneLevObj =  posTypeArr[oneLevIndex];
	var twoLevArr = oneLevObj.childContArr ;
    var twoLevhtml = "" ;
    for(var i = 0 , len = twoLevArr.length; i < len ; i++ ){
	     var posTypeTwoLev = twoLevArr[i];
	     twoLevhtml += "<option  value=\""+posTypeTwoLev.content+"\" ccdKey=\""+posTypeTwoLev.id+"\" >"+posTypeTwoLev.content+"</option>";
	 }
    $(obj).next().html(twoLevhtml);

}

//增加职位类型
function addPosType(){
	var addPosTypeCount = $(".ptsol").length ;
	if(addPosTypeCount >= 4){
		alert('最多添加4个职位类型');
		return ;
	}
    var oneLevhtml = "" ;
    for(var i = 0 , len = posTypeArr.length; i < len ; i++ ){
	     var posTypeOneLev = posTypeArr[i];
	     oneLevhtml += "<option oneLevIndex='"+i+"' value=\""+posTypeOneLev.content+"\"  ccdKey=\""+posTypeOneLev.id+"\">"+posTypeOneLev.content+"</option>";
	 }
	$(".posTypeSelOneLev").append(oneLevhtml);
    var twoLevhtml = "" ;
    for(var i = 0 , len = firPosTypeTwoLevArr.length; i < len ; i++ ){
	     var posTypeTwoLev = firPosTypeTwoLevArr[i];
	     twoLevhtml += "<option  value=\""+posTypeTwoLev.content+"\"  ccdKey=\""+posTypeTwoLev.id+"\">"+posTypeTwoLev.content+"</option>";
	 }
	var html = "<label for=\"inputEmail3\" class=\"col-sm-2 control-label\"></label> "+
			    "<div class=\"col-sm-10\">"+
			     "<select id=\"provinceSel\" class=\"form-control ptsol\" style=\"display: inline-block;width: 300px;margin-right: 20px;\" onchange=\"changePosTypeSel(this);\">"+
			     oneLevhtml+
				 "</select>"+
	            " <select id=\"provinceId\" class=\"form-control ptstl \" style=\"display:inline-block;width: 300px;margin-right: 20px;\"  name=\"\" >"+
	             twoLevhtml+
	               "</select>"+
	              " <a  href=\"#\" onclick=\"deletePosType(this);return false;\">删除</a>"+
			   " </div>";
	$(".posTypeDiv").append(html);
	return false ;
}

//删除职位类型
function deletePosType(obj){
	$(obj).parent().prev().remove();
	$(obj).parent().remove();
}

//==================================================================视频小节操作=============================================

//点击每个视频添加行中的“上传视频”按钮事件
//定义一个全部变量，用来存储当前点击的是哪个按钮
var checkedObj = null;
function upButClick(obj){
	document.getElementById('vcVideoFile').click();
	checkedObj = obj ; 
}


//上传视频到服务器,再中转到腾讯云
function uploadVcVideo(){
	$(checkedObj).text('上传中').attr('disabled',true).removeClass('btn-success').addClass('btn-warning');
	$.ajaxFileUpload
	(
		{
			url:'/sysVideoCourse/uploadVideo', 
			secureuri:false,
			fileElementId:'vcVideoFile',
			dataType: 'json',
			success: function (data, status)
			{
			   $(checkedObj).text('上传视频').attr('disabled',false).removeClass('btn-warning').addClass('btn-success');
				if(data.error){
					alert(data.error);
					return ;
				}
			     $(checkedObj).parent().prev().find('input').val(data.fileid);
			},
			error: function (data, status, e)
			{
				alert(e);
			}
		}
	)
}

//添加一个视频小节添加行
function addVcSecTr(){
	var num = $("#vcSecAddListTbody").children().length;
	
	$("#vcSecAddListTbody").append( "<tr>"+
			                          "<td>"+(num+1)+"</td>"+
									 "   <td><input name=\"sec_title[]\" type=\"text\" class=\"form-control input-sm vcSecNameInput\" placeholder=\"小节名称,不超过40个字符.\" required maxlength=\"40\"  style=\"width:350px;display:inline-block;margin-right: 20px;\"></td>"+
									 "   <td><input name=\"video_id[]\" type=\"text\" class=\"form-control input-sm\ vcSecVideoIdInput\" placeholder=\"腾讯云视频ID.\" required   style=\"width:150px;display:inline-block;margin-right: 20px;\" >"+
									     "</td>"+
									     "   <td>"+
									 "       <button type=\"button\" class=\"btn btn-success btn-sm\" onclick=\"upButClick(this);return false;\">上传视频</button>"+
									 "    </td>"+
									 "   <td><input name=\"sec_order_num[]\" type=\"number\" class=\"form-control input-sm vcSecOdBumInput\" placeholder=\"排序号\" value=\"0\" style=\"width:50px;display:inline-block;margin-right: 20px;\"></td>"+
						              "    <td>"+
									"		<select name=\"play_condition[]\"  class=\"form-control vcSecVideoPlayCondSel\"  style=\"display: inline-block;width: 100px;margin-right: 20px;\" >"+
									"			<option value=\"0\" >免登录</option>"+
									"			<option value=\"1\" >需登录</option>"+
									"			<option value=\"2\" >需购买</option>"+
									 "       </select>"+
									"	 </td>"+
									 "  <td>"+
										"	 <button type=\"button\" class=\"btn btn-danger btn-sm\" onclick=\"deleteVcSecTr(this);return false;\">删除</button>"+
										"</td>"+
									 " </tr>");
}

//删除视频小节添加行
function deleteVcSecTr(obj){
	$(obj).parent().parent().remove();
}

//检查视频小节内容数据是否正确
function submitVcSecs(){
	
	var secNameArr = $(".vcSecNameInput");
	for(var i = 0 , len = secNameArr.length ; i < len ; i++){
		var secName = $(secNameArr.get(i)).val();
		if(secName.length <= 0 || secName.length >= 40){
			 alert('第'+(i+1)+'行小节名称为0--40长度的字符串');
			 return false ;
		}
	}
	
	var videoIdArr = $(".vcSecVideoIdInput");
	for(var i = 0 , len = videoIdArr.length ; i < len ; i++){
		var videoId = $(videoIdArr.get(i)).val();
		if(videoId.length != 20 || isNaN(videoId)){
			 alert('第'+(i+1)+'行视频ID格式有误,正确格式为20位的数字,如:14651978969257106271');
			 return false ;
		}
	}
}

//删除视频小节内容
function deleteVcSec(vcSecId){
	var flag = window.confirm('删除课程小节,但不会删除腾讯云中的视频文件,确定删除么？');
	if(flag == false){
		return ;
	}
	$.post("/sysVideoCourse/deleteVcSec",
			{'vcSecId':vcSecId},
			function(data){
				if(data.error){
					alert(data.error);
				}else {
					window.location.reload();
				}
			},
			"json"
			);
}

//显示出编辑框
function showVcSecEdit(obj){
	//先隐藏展示行
	$(obj).parent().parent().hide();
	
	//再赋值新建编辑行
	var vcSecTr = $(obj).parent().parent();
	var vcSecId = vcSecTr.find('td').eq(0).text();
	var vcSecTitle = vcSecTr.find('td').eq(1).text();
	var vcSecVideoId = vcSecTr.find('td').eq(2).text();
	var vcSecOrderNum = vcSecTr.find('td').eq(5).text();
	var vcSecPlayCond = vcSecTr.find('td').eq(6).attr('playCond');
	var playCondObj = {'0':'免登录','1':'需登录' ,'2':'需购买'};
	var playCondHtml = "<option value='"+vcSecPlayCond+"' >"+playCondObj[vcSecPlayCond]+"</option>";
	for ( var pc in playCondObj ){
		if(vcSecPlayCond == pc){
			continue;
		}
		playCondHtml +="<option value='"+pc+"' >"+playCondObj[pc]+"</option>";
	}
	
	$(obj).parent().parent().after("<tr > "+ 
					               "   <td>"+vcSecId+"</td>"+ 
					                "  <td><input type=\"text\" value=\""+vcSecTitle+"\" /></td>"+ 
					                "  <td>"+ 
					                "  <input type=\"text\" value=\""+vcSecVideoId+"\" />"+ 
					                "  </td>"+ 
					                 " <td><button type=\"button\" class=\"btn btn-success btn-sm\" onclick=\"upButClick(this);return false;\">上传视频</button></td>"+ 
					                "  <td></td>"+ 
					                "  <td><input type=\"text\" value=\""+vcSecOrderNum+"\" style=\"width:50px;display:inline-block;\"></td>"+ 
					                 " <td >	<select   class=\"form-control vcSecVideoPlayCondSel\"  style=\"display: inline-block;width: 100px;margin-right: 20px;\" >"+ 
					                 playCondHtml + 
					                 "       </select>"+ 
							       " </td>"+ 
					                "  <td>"+ 
					                   "     <button type=\"button\" class=\"btn  btn-primary btn-sm\" onclick=\"updateVcSec(this);\">保存</button>	"+ 
										"	<button type=\"button\" class=\"btn btn-warning btn-sm\" onclick=\"hideVcSecEdit(this);;\">取消</button>"+ 
									"</td>"+ 
					               " </tr>");
}

//隐藏编辑框
function hideVcSecEdit(obj){
	$(obj).parent().parent().prev().show();
	$(obj).parent().parent().remove();
}

//修改视频小节内容
function updateVcSec(obj){
	var vcSecTr = $(obj).parent().parent();
	var vcSecId = vcSecTr.find('td').eq(0).text();
	var vcSecTitle = vcSecTr.find('td').eq(1).find('input').val();
	var vcSecVideoId = vcSecTr.find('td').eq(2).find('input').val();
	var vcSecOrderNum = vcSecTr.find('td').eq(5).find('input').val();
	var vcSecPlayCond = vcSecTr.find('td').eq(6).find('select').val();
	
	if(vcSecTitle.length <= 0 || vcSecTitle.length >= 40){
		 alert('小节名称为0--40长度的字符串');
		 return false ;
	}
	
	if(vcSecVideoId.length != 20 || isNaN(vcSecVideoId)){
		 alert('视频ID格式有误,正确格式为20位的数字,如:14651978969257106271');
		 return false ;
	}
	$(obj).text('保存中').attr('disabled',true);
	$(obj).next().attr('disabled',true);
	$.post("/sysVideoCourse/updateVcSec",
			{'vcSecId':vcSecId,
		     'sec_title' : vcSecTitle ,
		     'video_id' : vcSecVideoId ,
		     'sec_order_num' : vcSecOrderNum ,
		     'play_condition' : vcSecPlayCond
		     },
			function(data){
				$(obj).text('保存').attr('disabled',false);
				$(obj).next().attr('disabled',false);
				
				if(data.error){
					alert(data.error);
				}else {
					alert('成功修改'+data.result+"条记录");
					window.location.reload();
				}
			},
			"json"
			);
}





