
//根据条件查询列表
var listParam = { 
		            "page":1 ,
		            "pageNum":15}
function getListByParam(){
	$.post("/Sysmvpidea/getListByParam",
			listParam,
		   function(data){
				$("#newsListTbody").empty();
				var dataArr = data.dataArr;
				for(var i = 0 , len = dataArr.length ; i < len ; i++){
					var title = dataArr[i].title;
					title = title.length < 30 ?title : title.substr(0,30) + "...";
					$("#newsListTbody").append(" <tr> "+
							                    "   <td>"+dataArr[i].id+"</td> "+
												"    <td style='width:500px' >"+title+"</td> "+
												"  <td>"+dataArr[i].type+"</td> "+
												"  <td>"+dataArr[i].pubdate+"</td> "+
												"  <td>"+dataArr[i].showdate+"</td> "+
												"  <td>	<a href=\"/Sysmvpidea/updateView/"+dataArr[i].id+"\"><button type=\"button\" class=\"btn btn-success btn-sm\" >修改</button></a> "+
												" 		 <button type=\"button\" class=\"btn btn-danger btn-sm\" onclick=\"deleteData("+dataArr[i].id+")\">删除</button> "+
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
	listParam.page = page;
	getListByParam();
}



//添加和修改的数据验证
function upCheck(){
	var newsTitImg = $("#newsTitImgInput").val();
	if(newsTitImg.replace(/\s+/g,"") == ""){
		alert("标题缩略图不能为空");
		return false ;
	}
	var newsTitle = $("#titleInput").val();
	if(newsTitle.replace(/\s+/g,"") == ""){
		alert("标题不能为空");
		return false ;
	}
	var type = $("#typeInput").val();
	if(type.replace(/\s+/g,"") == ""){
		alert("类型不能为空");
		return false ;
	}
	var newsDesc = $("#newsDescTt").val();
	if(newsDesc.replace(/\s+/g,"") == ""){
		alert("摘要不能为空");
		return false ;
	}

	return true;
}

//删
function deleteData(nId){
	var flag = window.confirm("确定删除么？");
	if(flag == false ){
		return ;
	}
	$.post("/Sysmvpidea/delete",
			   {"id" : nId},
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
function updateTitPic(){
	$.ajaxFileUpload
	(
		{
			url:'/Sysmvpidea/upTitPic', 
			secureuri:false,
			fileElementId:'newsImgFile',
			dataType: 'json',
			success: function (data, status)
			{
				if(data.error){
					alert(data.error);
					return ;
				}
			     $("#newsTitImg").attr('src','/uploads/manager/mvpidea/'+data.thumbImgName);
			     $("#newsTitImgInput").val(data.imgName);
			},
			error: function (data, status, e)
			{
				alert(e);
			}
		}
	)
}
