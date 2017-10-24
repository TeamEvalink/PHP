<!DOCTYPE html>

<html lang="zh-CN"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="http://v3.bootcss.com/favicon.ico">

    <title>添加账号|系统设置|后台管理系统</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo site_url("/managResource/bootstrap-3.3.5-dist/css/bootstrap.min.css")?>" rel="stylesheet">

    <link href="<?php echo site_url("/managResource/css/dashboard.css")?>" rel="stylesheet">
    <link href="<?php echo site_url("/managResource/css/advert.css")?>" rel="stylesheet">
    <link href="<?php echo site_url("/managResource/bootstrap-datepicker-1.4.0-dist/css/bootstrap-datepicker.css")?>" rel="stylesheet">

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo site_url("/managResource/js/jquery.min.js")?>"></script>
    <script src="<?php echo site_url("/managResource/js/bootstrap.min.js")?>"></script>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?php echo site_url("/managResource/js/ie10-viewport-bug-workaround.js")?>"></script>
    <script src="<?php echo site_url("/managResource/js/ie-emulation-modes-warning.js")?>"></script>

  </head>

  <body>
	<?php $this->load->view('manage/header');?>
    <div class="container-fluid">
      	<div class="row">		
		<?php $this->load->view('manage/menu');?>
		
	        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	          	<h3 class="page-header"><a href="<?php echo site_url("/sysclient")?>">新增小朋友</a></h3>
			  	<div id="form_box">       
			      	<form class="form-horizontal" id="childedit" method="post" enctype=”multipart/form-data”>

			      		<div class="modal-body">
					       	<div class="form-group">
						   		<label for="inputEmail3" class="col-sm-2 control-label">小朋友姓名</label>
						    	<div class="col-sm-10">
						      		<input name="child_name"  type="text" style="width:60%" class="form-control" id="child_name" placeholder="小朋友姓名" value="">
						   		</div>
						  	</div>
				      	</div>

				      	<div class="modal-body">
					       	<div class="form-group">
						   		<label for="inputEmail3" class="col-sm-2 control-label">助记码</label>
						    	<div class="col-sm-10">
						      		<input name="shot_name"  type="text" style="width:60%" class="form-control" id="shot_name" placeholder="助记码" value="">
						   		</div>
						  	</div>
				      	</div>

				      	<div class="modal-body">
					       	<div class="form-group">
						   		<label for="inputEmail3" class="col-sm-2 control-label">性别</label>
						    	<select class="form-control" style="width : 200px;"  id="child_sex" name="child_sex">
						 			<option value="男">男</option>
						  			<option value="女">女</option>
								</select>
						  	</div>						  	
					    </div>

					    <div class="modal-body">
					       	<div class="form-group">
						   		<label for="inputEmail3" class="col-sm-2 control-label">昵称</label>
						    	<div class="col-sm-10">
						      		<input name="nickname"  type="text" style="width:60%" class="form-control" id="nickname" placeholder="昵称" value="" required >
						   		</div>
						  	</div>
				      	</div>

				      	<div class="modal-body">
					       	<div class="form-group">
						   		<label for="inputEmail3" class="col-sm-2 control-label">生日</label>
						    	<div class="col-sm-10">
						      		<input name="brithday"  type="text" style="width:60%" class="form-control" id="brithday" placeholder="生日" value="" required >
						   		</div>
						  	</div>
				      	</div>

				      	<div class="modal-body">
					       	<div class="form-group">
						   		<label for="inputEmail3" class="col-sm-2 control-label">年龄</label>
						    	<div class="col-sm-10">
						      		<input name="child_age"  type="text" style="width:60%" class="form-control" id="child_age" placeholder="年龄" value="" required >
						   		</div>
						  	</div>
				      	</div>

				      	<div class="modal-body">
					       	<div class="form-group">
						   		<label for="inputEmail3" class="col-sm-2 control-label">状态</label>
						    	<select class="form-control" style="width : 200px;"  id="is_ban" name="is_ban">
						 			<option value="1">正常</option>
						  			<option value="2">挂起</option>
								</select>
						  	</div>						  	
					    </div>
					    <input name="client_id"  type="hidden"  id="client_id" value="<?php echo $client_id;?>">
					    
					    <div class="modal-footer">
					        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="javascript:history.back(-1);">关闭</button>
					        <button type="button" class="btn btn-primary" onclick="addmarket()">添加</button>
					    </div>
			      	</form>
				</div>
	        </div>
      	</div>
    </div>
<script type="text/javascript">
	function addmarket(){
		$.post("/syschild/childAddActive", 
			$("#childedit").serialize(),
			function(data){			
				if (data.status==0) {
					alert(data.info);
					return ;
				}
				if (data.status==1) {
					alert(data.info);
					window.location.href="/syschild/child/<?php echo $client_id;?>";
				}
				
			},
			'json');
	}
</script>
</body>
</html>