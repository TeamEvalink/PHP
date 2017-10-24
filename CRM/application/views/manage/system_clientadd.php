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
	          	<h3 class="page-header"><a href="<?php echo site_url("/sysclient")?>">新增潜在客户</a></h3>
			  	<div id="form_box">       
			      	<form class="form-horizontal" id="clientedit" method="post" enctype=”multipart/form-data”>

				      	<div class="modal-body">
					       	<div class="form-group">
						   		<label for="inputEmail3" class="col-sm-2 control-label">客户来源</label>
						    	<select class="form-control" style="width : 200px;margin-left: 310px;"  id="customer_from" name="customer_from">
						 			<option value="市场活动">市场活动</option>
						  			<option value="call-in">call-in</option>
						  			<option value="walk-in" >walk-in</option>
						  			<option value="referral" >referral</option>
								</select>
						  	</div>						  	
					    </div>

					    <div class="modal-body">
					       	<div class="form-group">
						   		<label for="inputEmail3" class="col-sm-2 control-label">市场渠道</label>
						    	<select class="form-control" style="width : 200px;margin-left: 310px;"  id="market" name="market">
						    	<?php foreach($mark_name AS $k => $v){?>
						 			<option value="<?php echo $v->market_id; ?>"><?php echo $v->market_name; ?></option>
						 		<?}?>			
								</select>
						  	</div>
					    </div>

					    <div class="modal-body">
					       	<div class="form-group">
						   		<label for="inputEmail3" class="col-sm-2 control-label">客户类型</label>
						    	<select class="form-control" style="width : 200px;margin-left: 310px;"   name="customer_type" id="customer_type">
						 			<option value="潜在用户">潜在用户</option>
						  			<option value="有效客户">有效客户</option>
						  			<option value="历史客户" >历史客户</option>
								</select>
						  	</div>						  	
					    </div>

					    <div class="modal-body">
					       	<div class="form-group">
						   		<label for="inputEmail3" class="col-sm-2 control-label">成交率</label>
						    	<select class="form-control" style="width : 200px;margin-left: 310px;"   name="customer_ratio" id="customer_ratio">
						 			<option value="A">A</option>
						  			<option value="B">B</option>
						  			<option value="C" >C</option>
						  			<option value="D" >D</option>
								</select>
						  	</div>						  	
					    </div>

				      	<div class="modal-body">
					       	<div class="form-group">
						   		<label for="inputEmail3" class="col-sm-2 control-label">父亲姓名</label>
						    	<div class="col-sm-10">
						      		<input name="father_name"  type="text" style="width:60%" class="form-control" id="father_name" placeholder="父亲姓名" value="">
						   		</div>
						  	</div>
				      	</div>

				      	<div class="modal-body">
					       	<div class="form-group">
						   		<label for="inputEmail3" class="col-sm-2 control-label">父亲手机号</label>
						    	<div class="col-sm-10">
						      		<input name="father_tel"  type="text" style="width:60%" class="form-control" id="father_tel" placeholder="父亲手机号" value="">
						   		</div>
						  	</div>
				      	</div>

				      	<div class="modal-body">
					       	<div class="form-group">
						   		<label for="inputEmail3" class="col-sm-2 control-label">母亲姓名</label>
						    	<div class="col-sm-10">
						      		<input name="mather_name"  type="text" style="width:60%" class="form-control" id="mather_name" placeholder="母亲姓名" value="">
						   		</div>
						  	</div>
				      	</div>

				      	<div class="modal-body">
					       	<div class="form-group">
						   		<label for="inputEmail3" class="col-sm-2 control-label">母亲手机号</label>
						    	<div class="col-sm-10">
						      		<input name="mather_tel"  type="text" style="width:60%" class="form-control" id="mather_tel" placeholder="母亲手机号" value="">
						   		</div>
						  	</div>
				      	</div>

				      	<div class="modal-body">
					       	<div class="form-group">
						   		<label for="inputEmail3" class="col-sm-2 control-label">创建日期</label>
						    	<div class="col-sm-10">
						      		<input name="input_time"  type="text" style="width:60%" class="form-control" id="input_time" placeholder="创建日期" value="" required >
						   		</div>
						  	</div>
				      	</div>


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
		$.post("/sysclient/addActive", 
			$("#clientedit").serialize(),
			function(data){			
				if (data.status==0) {
					alert(data.info);
					return ;
				}
				if (data.status==1) {
					alert(data.info);
					window.location.href="/sysclient/index";
				}
				
			},
			'json');
	}
</script>
</body>
</html>