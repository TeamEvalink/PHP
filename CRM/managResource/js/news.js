
//根据条件查询新闻列表
var newsParam = { "keyword" : "" ,
		            "page":1 ,
		            "pageNum":15}
function getNewsByParam(){
	newsParam.keyword = $("#newsTitKeyWordInput").val();
	$.post("/sysnews/getNewsByParam",
			newsParam,
		   function(data){
				$("#newsListTbody").empty();
				var newsData = data.dataArr;
				for(var i = 0 , len = newsData.length ; i < len ; i++){
					var title = newsData[i].title;
					title = title.length < 30 ?title : title.substr(0,30) + "...";
					$("#newsListTbody").append(" <tr> "+
							                    "   <td>"+newsData[i].id+"</td> "+
												"    <td style='width:500px' >"+title+"</td> "+
												"  <td>"+newsData[i].pub_date+"</td> "+
												"  <td>"+newsData[i].click_num+"</td> "+
												"  <td>	<a href=\"/sysnews/updateView/"+newsData[i].id+"\"><button type=\"button\" class=\"btn btn-success btn-sm\" >修改</button></a> "+
												" 		 <button type=\"button\" class=\"btn btn-danger btn-sm\" onclick=\"deleteNews("+newsData[i].id+")\">删除</button> "+
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
	newsParam.page = page;
	getNewsByParam();
}

//关键字查询
function seachNews(){
	newsParam.page = 1 ;
	getNewsByParam();
}

//添加新闻和修改新闻的数据验证
function upNewsCheck(){
	var newsTitImg = $("#newsTitImgInput").val();
	if(newsTitImg.replace(/\s+/g,"") == ""){
		alert("新闻标题缩略图不能为空");
		return false ;
	}
	var newsWxImg = $("#newsWxImgInput").val();
	if(newsWxImg.replace(/\s+/g,"") == ""){
		alert("微信分享图不能为空");
		return false ;
	}
	var newsTitle = $("#titleInput").val();
	if(newsTitle.replace(/\s+/g,"") == ""){
		alert("新闻标题不能为空");
		return false ;
	}
	var keyWord = $("#keyWordInput").val();
	if(keyWord.replace(/\s+/g,"") == ""){
		alert("新闻关键字不能为空");
		return false ;
	}
	var newsDesc = $("#newsDescTt").val();
	if(newsDesc.replace(/\s+/g,"") == ""){
		alert("新闻摘要不能为空");
		return false ;
	}
	var clickNum = $("#clickNumInput").val();
	if(clickNum.replace(/\s+/g,"") == ""){
		alert("点击量不能为空");
		return false ;
	}
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

//预览广告
function previewAdvert(adId){
	$('#previewAdvertModel').find("iframe").attr("src" , "/sysadvert/preview/"+adId);
	
	$('#previewAdvertModel').modal();
}

//上传新闻标题图片
function updateNewsTitPic(){
	$.ajaxFileUpload
	(
		{
			url:'/sysnews/upNewsTitPic', 
			secureuri:false,
			fileElementId:'newsImgFile',
			dataType: 'json',
			success: function (data, status)
			{
				if(data.error){
					alert(data.error);
					return ;
				}
			     $("#newsTitImg").attr('src','/uploads/manager/news/'+data.thumbImgName);
			     $("#newsTitImgInput").val(data.imgName);
			},
			error: function (data, status, e)
			{
				alert(e);
			}
		}
	)
}
//上传新闻微信分享图片
function updateNewsWxPic(){
	$.ajaxFileUpload
	(
		{
			url:'/sysnews/upNewsWxPic', 
			secureuri:false,
			fileElementId:'newsWxImgFile',
			dataType: 'json',
			success: function (data, status)
			{
				if(data.error){
					alert(data.error);
					return ;
				}
			     $("#newsWxImg").attr('src','/uploads/manager/news/'+data.imgName);
			     $("#newsWxImgInput").val(data.imgName);
			},
			error: function (data, status, e)
			{
				alert(e);
			}
		}
	)
}