
//删除活动
function deleteAdvert(adId){
	var flag = window.confirm("确定删除么？");
	if(flag == false ){
		return ;
	}
	//Ajax
                $.ajax({
                    url: '/sysuser/deleteActive',
                    type: 'post',
                    data: {
                        'id': adId
                    },
                    success: function (data) {
                        //alert(data);

						if(data == 1){
							alert('删除成功');
						}else{
							alert('删除失败');
						}
                        window.location.href="/sysuser"; 
                    }
                });
      //Ajax end
}
function updateuser(id){
	$.post("/sysuser/Act_update", $("#useredit").serialize(),
			function (data){
				//console.log(data);
				if(data == 'relogin'){
					alert("请重新登录！");
					return ;
				}
				alert(data);
				window.location.href="/sysuser";
	        },
	        "text"
			);
}

function adduser(){
	
	$.post("/sysuser/addActive", $("#useredit").serialize(),function(data){
			if (data.status==0) {
				alert(data.info);
				return ;
			}
			if (data.status==1) {
				alert(data.info);
				window.location.href="/sysuser";
			}

		},'json');
}
