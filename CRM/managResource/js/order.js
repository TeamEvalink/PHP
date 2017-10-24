
//根据条件查询订单列表
var orderParam = { "proType" : -1 ,
		        "isPay" : -1 , 
		            "page":1 ,
		            "pageNum":10}
function getOrderByParam(){
	$.post("/SysOrder/getOrderByParam",
			orderParam,
		   function(data){
				$("#vcListTbody").empty();
				var dataArr = data.dataArr;
				var platformObj = {'0':'PC' , '1':'ios','2':'android'} //'购买平台  0--pc 1--ios 2--android',
				var proTypeObj = {'0':'VIP购买' ,'1':'课程购买'} ;
				
				for(var i = 0 , len = dataArr.length ; i < len ; i++){

					$("#vcListTbody").append(" <tr> "+
							                    "   <td>"+dataArr[i].id+"</td> "+
												"    <td  >"+dataArr[i].trade_no+"</td> "+
												"    <td  >"+dataArr[i].order_date+"</td> "+
												"  <td>"+platformObj[''+dataArr[i].platform]+"</td> "+
												"  <td>"+proTypeObj[''+dataArr[i].product_type]+"</td> "+
												"  <td>"+dataArr[i].fee+"</td> "+
												"  <td>"+dataArr[i].is_pay+"</td> "+
												"  <td>	" +
												" 	<a target='_blank' href=\"/SysOrder/details/"+dataArr[i].id+"\"><button type=\"button\" class=\"btn btn-success btn-sm\" >详情</button></a>"+
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
	orderParam.page = page;
	getOrderByParam();
}

//改变订单类型
function changeProType(obj){
	orderParam.proType = $(obj).val();
	getOrderByParam();
}

//改变订单支付状态
function changeIsPay(obj){
	orderParam.isPay = $(obj).val();
	getOrderByParam();
}








