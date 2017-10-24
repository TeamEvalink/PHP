var tea_img = '';
var tea_thimg = '';
var act_img = '';
var act_thimg = '';
var share_img = '';


function teacherFile(){
    document.getElementById("teacher_img").click();
}
function activeFile(){
    document.getElementById("active_img").click();
}
function shareFile(){
    document.getElementById("share_img").click();
}

var i = $('#Ptea_img').val();
//老师上传
function teacherImgUpload(){
    //console.log("teacher");
		//Ajax上传		
    $.ajaxFileUpload({
        url: '/seekerfind/teacher_upload', //用于文件上传的服务器端请求地址
        secureuri: false, //是否需要安全协议，一般设置为false
        fileElementId: 'teacher_img', //文件上传域的ID
        dataType: 'json', //返回值类型 一般设置为json
        success: function (data, status)  //服务器成功响应处理函数
        {

			//Ajax删除图片
                $.ajax({
                    url: '/seekerfind/img_unlink',
                    type: 'post',
                    data: {
						'tea_img':tea_img,
						'tea_thimg':tea_thimg,
						'act_img':'',
						'act_thimg':''
                    },                  
                });
        //Ajax end

            $("#tea_img").attr("src", "/uploads/find/teacher_img/"+data.th_img);
			tea_img = data.img;
			tea_thimg = data.th_img;
			$('#h_tea_img').val(tea_img);
			$('#h_tea_thimg').val(tea_thimg);	
            if (typeof (data.error) != 'undefined') {
                if (data.error != '') {
                    alert(data.error);
                } else {
                    alert(data.msg);
                }
            }        				
         },
        error: function (data, status, e)//服务器响应失败处理函数
        {
            alert(e);
        }
    });
            return false;
}

//微信封面上传
function shareImgUpload(){
  
        //Ajax上传        
    $.ajaxFileUpload({
        url: '/seekerfind/share_img_upload', //用于文件上传的服务器端请求地址
        secureuri: false, //是否需要安全协议，一般设置为false
        fileElementId: 'share_img', //文件上传域的ID
        dataType: 'json', //返回值类型 一般设置为json
        success: function (data, status)  //服务器成功响应处理函数
        {

            $("#share_file").attr("src", "/uploads/find/teacher_img/"+data.th_img);
            share_img = data.img;

            if (typeof (data.error) != 'undefined') {
                if (data.error != '') {
                    alert(data.error);
                } else {
                    alert(data.msg);
                }
            }                       
         },
        error: function (data, status, e)//服务器响应失败处理函数
        {
            alert(e);
        }
    });
            return false;
}

//活动上传
function activeImgUpload(){
   $.ajaxFileUpload({
        url: '/seekerfind/active_upload', //用于文件上传的服务器端请求地址
        secureuri: false, //是否需要安全协议，一般设置为false
        fileElementId: 'active_img', //文件上传域的ID
        dataType: 'json', //返回值类型 一般设置为json
        success: function (data, status)  //服务器成功响应处理函数
        {
			//Ajax删除图片
                $.ajax({
                    url: '/seekerfind/img_unlink',
                    type: 'post',
                    data: {
						'tea_img':'',
						'tea_thimg':'',
						'act_img':act_img,
						'act_thimg':act_thimg
                    },                   
                });
        //Ajax end

            $("#act_img").attr("src", "/uploads/find/active_img/"+data.th_img);
			act_img = data.img;
			act_thimg = data.th_img;

			$('#h_act_img').val(act_img);
			$('#h_act_thimg').val(act_thimg);

            if (typeof (data.error) != 'undefined') {
                if (data.error != '') {
                    alert(data.error);
                } else {
                    alert(data.msg);
                }
            }
            
				
         },
        error: function (data, status, e)//服务器响应失败处理函数
        {
            alert(e);
        }
    });
            return false;
}




function check(){
	var title = $('#title').val();
	var address = $('#address').val();
	var tag = $('#tag').val();
	//var active_time = $('#active_time').val();
	var student = $('#student').val();
	var teacher = $('#teacher').val();
	var tea_intro = editor1.html();
	var star = $('#star').val();
	var content = editor2.html();
	var is_show = $('#is_show').val();
    var city = $('#posInfoDiv_city').html();
    var kind = $('#kind').val();
    var zan_number = $('#zan_number').val();
    var limit_number = $('#limit_number').val();
    var zhaiyao = $('#zhaiyao').val();

    var radio = $("input[name='time_radio']:checked").val(); 

    if(radio == 1){
        active_time = $('#active_time_1').val();
    }else if(radio == 2){
        active_time = $('#active_time_2').val()+'/'+$('#active_time_3').val();
    }

	if(tea_img == ''){
		alert('请上传主讲老师图片');
		return false;
	}else if(act_img == ''){
		alert('请上传活动封面图片');
		return false;
	}

	//Ajax传入数据库
                $.ajax({
                    url: '/find/addActive',
                    type: 'post',
                    data: {
						
                        'title': title,
                        'address': address,
                        'active_time': active_time,
                        'tag': tag,
                        'student': student,
						'star': star,
                        'teacher': teacher,
						'tea_intro':tea_intro,
						'teacher_img':tea_img,
						'tea_thimg':tea_thimg,
						'active_img':act_img,
						'activethu_img':act_thimg,
					    'content':content,
						'is_show':is_show,
                        'city':city,
                        'kind':kind,
                        'day_num':radio,
                        'zan_number':zan_number,
                        'limit_number':limit_number,
                        'share_img':share_img,
                        'zhaiyao':zhaiyao

                    },
                    success: function (data1) {
                        alert(data1);
                            location.href = "/find";
                    }
                });
                //Ajax end
}

function update(){

	var title = $('#title').val();
	var address = $('#address').val();
	var tag = $('#tag').val();
	//var active_time = $('#active_time').val();
	var student = $('#student').val();
	var teacher = $('#teacher').val();
	var tea_intro = editor1.html();
	var star = $('#star').val();
	var content = editor2.html();
	var act_id = $('#act_id').val();
	var tea_img = $('#h_tea_img').val();
	var tea_thimg = $('#h_tea_thimg').val();
	var act_img = $('#h_act_img').val();
	var act_thimg = $('#h_act_thimg').val();
	var is_show = $('#is_show').val();
    var kind = $('#kind').val();
    var city = $('#city').val();
    var zan_number = $('#zan_number').val();
    var limit_number = $('#limit_number').val();
    var zhaiyao = $('#zhaiyao').val();

    if(!city){
        city = '';
    }


    var radio = $("input[name='time_radio']:checked").val(); 

    if(radio == 1){
        active_time = $('#active_time_1').val();
    }else if(radio == 2){
        active_time = $('#active_time_2').val()+'/'+$('#active_time_3').val();
    }


	//Ajax传入数据库
                $.ajax({
                    url: '/find/Act_update',
                    type: 'post',
                    data: {

						'id':act_id,
                        'title': title,
                        'address': address,
                        'active_time': active_time,
                        'tag': tag,
                        'student': student,
						'star': star,
                        'teacher': teacher,
						'tea_intro':tea_intro,
						'teacher_img':tea_img,
						'tea_thimg':tea_thimg,
						'active_img':act_img,
						'activethu_img':act_thimg,
					    'content':content,
						'is_show':is_show,
                        'city':city,
                        'kind':kind,
                        'day_num':radio,
                        'zan_number':zan_number,
                        'zhaiyao':zhaiyao,
                        'share_img':share_img,
                        'limit_number':limit_number
						
                    },
                    success: function (data1) {
                     
                            alert(data1);
                            location.href = "/find";
                       
                    }
                });
                //Ajax end

}

function close_btns(){
	//Ajax删除图片
                $.ajax({
                    url: '/seekerfind/img_unlink',
                    type: 'post',
                    data: {

						'tea_img':tea_img,
						'tea_thimg':tea_thimg,
						'act_img':act_img,
						'act_thimg':act_thimg
                    },
                    success: function (data) {
                      alert(data);
                    }
                });
        //Ajax end

		location.href="/find"

}
