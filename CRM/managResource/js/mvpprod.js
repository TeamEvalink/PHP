



//添加和修改的数据验证
function upCheck(){
	var photoImgFileInput = $("#photoImgFileInput").val();
	if(photoImgFileInput.replace(/\s+/g,"") == ""){
		alert("封面不能为空");
		return false ;
	}
	var titleInput = $("#titleInput").val();
	if(titleInput.replace(/\s+/g,"") == ""){
		alert("标题不能为空");
		return false ;
	}
	var holdtimeInput = $("#holdtimeInput").val();
	if(holdtimeInput.replace(/\s+/g,"") == ""){
		alert("举办时间不能为空");
		return false ;
	}
	var priceInput = $("#priceInput").val();
	if(priceInput.replace(/\s+/g,"") == ""){
		alert("价格不能为空");
		return false ;
	}
	var placeInput = $("#placeInput").val();
	if(placeInput.replace(/\s+/g,"") == ""){
		alert("地点不能为空");
		return false ;
	}
	

	return true;
}

//删
function deleteData(id){
	var flag = window.confirm("确定删除么？");
	if(flag == false ){
		return ;
	}
	$.post("/Sysmvpprod/delete",
			   {"id" : id },
			   function(data){
					window.location.reload();
			   },
			   "json"
			   );
}

//删除文件
function deleteFile(id){
	var flag = window.confirm("确定删除么？");
	if(flag == false ){
		return ;
	}
	$.post("/Sysmvpprod/deleteFile",
			   {"fid" : id },
			   function(data){
					window.location.reload();
			   },
			   "json"
			   );
}

//设为封面
function setCover(id){
	var flag = window.confirm("确定设为封面么？");
	if(flag == false ){
		return ;
	}
	$.post("/Sysmvpprod/setCover",
			   {"fid" : id },
			   function(data){
					window.location.reload();
			   },
			   "json"
			   );
}


//上传标题图片
function updateTitPic(obj){
	var id = $(obj).attr('id');
	$.ajaxFileUpload
	(
		{
			url:'/Sysmvpservice/upTitPic', 
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
