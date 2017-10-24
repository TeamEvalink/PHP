



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
	$.post("/Sysmvpservice/delete",
			   {"id" : id },
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

function changeCityVal(obj) {
	$(".place").val($(obj).val());
	$(".city0").val($(obj).find("option:selected").html());
}

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
	$(".service_type").val($(obj).val());
	$(".profession0").val($(obj).find("option:selected").html());
}