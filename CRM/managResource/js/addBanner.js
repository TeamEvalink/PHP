/**
 * Created by 大刀王五 on 2015/8/27.
 */
//    图片上传组件
var flagImg;
var firstButtonShow = true;
function imgUpload() {
	$('.imgUploadDialogCover').show();
    $.ajaxFileUpload({
        url:'/Sysapp/getHeaderPhoto',
        secureuri:false,
        fileElementId:'upload',
        dataType: 'json',
        success: function (data, status){
	        if(data.error){
	            singleAlert(data.error);
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
            $(".jcrop-holder").find("img").attr("src","/uploads/app/banner/"+data.result);
            $(".jcrop-holder").show();
	        $("#logoPreview").attr("src", "/uploads/app/banner/"+data.result);
	        $("#logoPreview").hide();
	        $("#logoPreviewHidden").attr("src", "/uploads/app/banner/"+data.result);
	        $(".cutButton").show();
	        $(".cutButton_1").show();
            $(".upDiv").find("input").hide();
        },error: function (data, status, e){
            singleAlert(e);
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
    	$.post('/Sysapp/deletePhoto' ,
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
	$.post('/Sysapp/cutHeaderPhoto' ,
				param
				,
			   function(data){
				   if(data.fail){
					   $('.cutButton').val("确定");
					   $('.cutButton').css({'background':'#da4571','border':'1px solid #da4571'});
					   $('.cutButton').removeAttr('disabled');
                       singleAlert(data.fail);
					   return ;
				   }
				   $('.cutButton').val("确定");
				   $('.cutButton').css({'background':'#da4571','border':'1px solid #da4571'});
				   $('.cutButton').removeAttr('disabled');
				   $("#logoPreview").attr("src", "/uploads/app/banner/"+data.succ);
				   $("#compInfoInput_logo").val(data.succ);
				   $("#logoPreview").show();
				   $(".jcrop-holder").hide();
				   $(".cutButton").hide();
				   $(".cutButton_1").val("重新上传");
			   },
			   "json"
		     );
}


//用户信息提交验证
function regitInfoSubmit(){
	var name = $("#name").val();
	if(name.replace(/\s+/g,"") == "" ){
        singleAlert("名称不能为空");
		return false ;
	}
	var photo = $("#compInfoInput_logo").val();
	if(photo == "" || photo == undefined){
        singleAlert("请设置banner");
		return false ;
	}
	
	
	var type = $("input[name='menutype']:checked").val();
	if(type == "" || type == undefined){
        singleAlert("链接到类别未选择");
		return false ;
	}
	var typeid = $("#typeid").val();
	if(typeid.replace(/\s+/g,"") == "" ){
        singleAlert("id不能为空");
		return false ;
	}
	
	return true ;
}










