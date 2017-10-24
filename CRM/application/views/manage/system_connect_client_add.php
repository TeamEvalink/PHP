<!DOCTYPE html>

<html lang="zh-CN"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="http://v3.bootcss.com/favicon.ico">

    <title>添加联系计划|系统设置|后台管理系统</title>

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
	          	<h3 class="page-header"><a href="<?php echo site_url("/sysclient")?>">新增联系计划</a></h3>
			  	<div id="form_box">       
			      	<form class="form-horizontal" id="clientedit" method="post" enctype=”multipart/form-data”>

				      	<div class="modal-body">
					       	<div class="form-group">
						   		<label for="inputEmail3" class="col-sm-2 control-label">联系人姓名</label>
						    	<div class="col-sm-10">
						      		<input name="connect_name"  type="text" style="width:60%" class="form-control" id="connect_name" placeholder="联系人姓名" value="">
						   		</div>
						  	</div>
				      	</div>

				      	<div class="modal-body">
					       	<div class="form-group">
						   		<label for="inputEmail3" class="col-sm-2 control-label">联系人电话</label>
						    	<div class="col-sm-10">
						      		<input name="connect_tel"  type="text" style="width:60%" class="form-control" id="connect_tel" placeholder="联系人电话" value="">
						   		</div>
						  	</div>
				      	</div>				      	

				      	<div class="modal-body">
					       	<div class="form-group">
						   		<label for="inputEmail3" class="col-sm-2 control-label">联系日期</label>
						    	<div class="col-sm-10">
						      		<input name="connect_date"  type="text" style="width:60%" class="form-control" id="connect_date" placeholder="联系日期" value="">
						   		</div>
						  	</div>
				      	</div>

				      	<div class="modal-body">
					       	<div class="form-group">
						   		<label for="inputEmail3" class="col-sm-2 control-label">联系内容</label>
						    	<div class="col-sm-10">
						    		<textarea name="connect_info"  id="connect_info" style="width:60%"  placeholder="联系内容" class="form-control" rows="3"></textarea> 						      		
						   		</div>
						  	</div>
				      	</div>
				      	<input name="client_id"  type="hidden"  id="client_id" value="<?php echo $client_id;?>">

					    <div class="modal-footer">
					        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="javascript:history.back(-1);">关闭</button>
					        <button type="button" class="btn btn-primary" onclick="addconnect()">添加</button>
					    </div>
			      	</form>
				</div>
	        </div>
      	</div>
    </div>
<script type="text/javascript">
	function addconnect(){	
		$.post("/sysconnect/addActive", 
			$("#clientedit").serialize(),
			function(data){			
				if (data.status==0) {
					alert(data.info);
					return ;
				}
				if (data.status==1) {
					alert(data.info);
					window.location.href="/sysconnect/clientConnect/<?php echo $client_id; ?>";
				}
				
			},
			'json');
	}
</script>
</body>
</html>