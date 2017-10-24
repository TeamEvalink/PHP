
//获取注册账户		        
function getRegister(){
	var registerParam = {email : $("#regEmailKey").val() } ;
	  $.post("/sysenterprise/getRegisterUsers" ,
			  registerParam ,
			  function(data){
		  		 if(data.length == 0 ){
			  		 alert("未找到相关账户");
			  		 return ;
			  	 }
			  	 var regHtml = "" ;
			  	 for(var i = 0 ,len = data.length ; i < len ; i++){
				  	 var register = data[i];

				  	regHtml += "<option value='" + register.uid+"#"+ register.email + "#" + register.cid +"'>" + register.email+ "</option>";
				 }	
				 $("#registerSel").empty().html(regHtml);
		      },
		      "json"
		      );
	  
}

//城市选择
function changeCitySel(){
	var cityId = $("#provinceSel").val();
	$(".citySeletes").css("display",'none').removeAttr("name").removeClass('compInfoInput_city');
	$("#"+cityId).css("display",'inline-block').attr("name","city").addClass('compInfoInput_city');
}
//--------------------------------------------头像上传裁剪--------------------------------------------

var flagImg;
var firstButtonShow = true;
function imgUpload() {
	$('.imgUploadDialogCover').show();
    $.ajaxFileUpload({
        url:'/sysenterprise/getLogo',
        secureuri:false,
        fileElementId:'upload',
        dataType: 'json',
        success: function (data, status){
	        if(data.error){
	            alert(data.error);
	            return ;
	        }
            jQuery(function($){
                // Create variables (in this scope) to hold the API and image size
                var jcrop_api, boundx, boundy;
                $('#logoPreview').Jcrop({
                        minSize: [40,40],
                        setSelect: [0,0,120,120],
                        onSelect: updateCoords,
                        aspectRatio: 1
                    },
                    function (){
                        // Use the API to get the real image size
                        var bounds = this.getBounds();
                        boundx = bounds[0];
                        boundy = bounds[1];
                        // Store the API in the jcrop_api variable
                        jcrop_api = this;
                    }
                );
                function updateCoords(c)
                {
                    $('#x').val(c.x);
                    $('#y').val(c.y);
                    $('#w').val(c.w);
                    $('#h').val(c.h);
                };
            });
			$('.imgUploadDialogCover').hide();
			$(".cutButton_1").val("取消");
            $(".jcrop-holder").find("img").attr("src","/uploads/company/logo/"+data.result);
            $(".jcrop-holder").show();
	        $("#logoPreview").attr("src", "/uploads/company/logo/"+data.result);
	        $("#logoPreview").hide();
	        $("#logoPreviewHidden").attr("src", "/uploads/company/logo/"+data.result);
	        $(".cutButton").show();
	        $(".cutButton_1").show();
            $(".upDiv").find("input").hide();
        },error: function (data, status, e){
            alert(e);
        }});
    //  图片裁剪组件
    return false;
}
//取消上传
function uploadCancel() {
	$("#compInfoInput_logo").val("");
	var deleteImg = $("#logoPreview").attr("src");
    $("#logoPreview").attr("src", "clientResource/images/companyInfo_imgPreview.png");
    $("#logoPreviewHidden").attr("src", "clientResource/images/companyInfo_imgPreview.png");
	var scaleNum = ($("#logoPreview").width()/3)*2;
    $('#x').val('0');
    $('#y').val('0');
    $('#w').val(scaleNum);
    $('#h').val(scaleNum);
    $(".jcrop-holder").hide();
    $("#logoPreview").show();
    $(".cutButton").hide();
    $(".cutButton_1").hide();
	$(".cutButton_1").val("取 消");
    $(".upDiv").find("input").show();
    
    //取消之后将原来的图片删除
    if(deleteImg.indexOf("companyInfo_imgPreview") < 0 ){
    	$.post('/sysenterprise/deleteLogo' ,
				{"deleteImg" : deleteImg},
			   function(data){
			   },
			   "text"
		     );
    }
}


//确认裁剪logo图片, 上传裁剪的原图路径和裁剪坐标
function cutLogo(){
	$('.cutButton').val("上传中");
	$('.cutButton').css({'background':'#989898','border':'1px solid #989898'});
	$('.cutButton').attr('disabled',true);
	var scaleTimeX = $("#logoPreviewHidden").width()/180;
	var scaleTimeY = $("#logoPreviewHidden").height()/180;
	var newX = $("#x").val()*scaleTimeX;
	var newY = $("#y").val()*scaleTimeY;
	var newW = $("#w").val()*scaleTimeX;
	var newH = $("#h").val()*scaleTimeY;	
	var param = {srcPic : $("#logoPreview").attr("src"),
				x:newX ,
			    y:newY ,
				w:newW ,
				h:newH 
	         };
   console.log(param);
	$.post('/sysenterprise/cutLogo' ,
				param
				,
			   function(data){
				   if(data.fail){
					   $('.cutButton').val("确定");
					   $('.cutButton').css({'background':'#da4571','border':'1px solid #da4571'});
					   $('.cutButton').removeAttr('disabled');
                       alert(data.fail);
					   return ;
				   }
				   $('.cutButton').val("确定");
				   $('.cutButton').css({'background':'#da4571','border':'1px solid #da4571'});
				   $('.cutButton').removeAttr('disabled');
				   $("#logoPreview").attr("src", "/uploads/company/logo/"+data.succ);
				   $("#compInfoInput_logo").val(data.succ);
				   $("#logoPreview").show();
				   $(".jcrop-holder").hide();
				   $(".cutButton").hide();
				   $(".cutButton_1").val("重新上传");
			   },
			   "json"
		     );
}

//验证企业信息数据
function submitCompInfo(){
	var fullname = $("#compInfoInput_fullname").val();
	if(fullname.replace(/\s+/g,"") == ""  ){
		alert("公司全称不能为空");
		return false ;
	}
	
	var name = $("#compInfoInput_name").val();
	if(name.replace(/\s+/g,"") == "" ){
        alert('公司简称不能为空');
		return false ;
	}
    if(name.length > 12){
        alert('公司简称不能超过12个字');
        return false ;
    }
	
	var logo = $("#compInfoInput_logo").val();
	if(logo == "" || logo== undefined){
        alert("请设置公司LOGO");
		return false ;
	}
	
	
	var city = $(".compInfoInput_city").val();
	if(city == "" ){
        alert("请选择公司所在城市");
		return false ;
	}
	
	var locationX = $("#compInfoInput_locationX").val();
	var locationY = $("#compInfoInput_locationY").val();
	if(locationX == "" || locationY == ""){
        alert("请输入公司地址查询公司坐标");
		return false ;
	}
	
	var  buss = $("#compInfoInput_buss").val();
	if(buss == "" ){
        alert("请选择公司所属行业");
		return false ;
	}
	
	var  staff = $("#compInfoInput_staff").val();
	if(staff == "" ){
        alert("请选择公司规模情况");
		return false ;
	}
	
	var slogan = $("#compInfoInput_tags").val();
	if(slogan.replace(/\s+/g,"") == "" || slogan.length > 40){
        alert("一句话简介不能为空 ， 长度不超过40个字符");
		return false ;
	}
	return true ;
}