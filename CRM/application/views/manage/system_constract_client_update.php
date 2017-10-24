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
						   		<label for="inputEmail3" class="col-sm-2 control-label">合同编号</label>
						    	<div class="col-sm-10">
						      		<input name="contract_no"  type="text" style="width:60%" class="form-control" id="contract_no" placeholder="合同编号" value="<?php echo $list->contract_no;?>">
						   		</div>
						  	</div>
				      	</div>

				      	<div class="modal-body">
					       	<div class="form-group">
						   		<label for="inputEmail3" class="col-sm-2 control-label">合同金额</label>
						    	<div class="col-sm-10">
						      		<input name="contract_money"  type="text" style="width:60%" class="form-control" id="contract_money" placeholder="合同金额" value="<?php echo $list->contract_money;?>">
						   		</div>
						  	</div>
				      	</div>				      	

				      	<div class="modal-body">
					       	<div class="form-group">
						   		<label for="inputEmail3" class="col-sm-2 control-label">签约日期</label>
						    	<div class="col-sm-10">
						      		<input name="sign_date"  type="text" style="width:60%" class="form-control" id="sign_date" placeholder="签约日期" value="<?php echo $list->sign_date;?>">
						   		</div>
						  	</div>
				      	</div>

      					<div class="modal-body">
					       	<div class="form-group">
						   		<label for="inputEmail3" class="col-sm-2 control-label">合同期限</label>
						    	<div class="col-sm-10">
						      		<input name="contract_limit"  type="text" style="width:60%" class="form-control" id="contract_limit" placeholder="合同期限" value="<?php echo $list->contract_limit;?>">
						   		</div>
						  	</div>
				      	</div>

				      	<div class="modal-body">
					       	<div class="form-group">
						   		<label for="inputEmail3" class="col-sm-2 control-label">有效课时数</label>
						    	<div class="col-sm-10">
						      		<input name="class_num"  type="text" style="width:60%" class="form-control" id="class_num" placeholder="有效课时数" value="<?php echo $list->class_num;?>">
						   		</div>
						  	</div>
				      	</div>

					    <div class="modal-body">
					       	<div class="form-group">
						   		<label for="inputEmail3" class="col-sm-2 control-label">合同状态</label>
						    	<select class="form-control" style="width : 200px; margin-left:395px;"   name="contract_status" id="contract_status">
						 			<option value="1" <?php if($list->contract_status == 1) {echo 'selected';}?>>良好</option>
						 			
						  			<option value="2" <?php if($list->contract_status == 2) {echo 'selected';}?>>异常</option>
								</select>
						  	</div>						  	
					    </div>

					    <div class="modal-body">
					       	<div class="form-group">
						   		<label for="inputEmail3" class="col-sm-2 control-label">合同情况</label>
						    	<select class="form-control" style="width : 200px; margin-left:395px;"   name="contract_condition" id="contract_condition">
						 			<option value="1" <?php if($list->contract_condition == 1) {echo 'selected';}?>>已生效</option>
						  			<option value="2" <?php if($list->contract_condition == 2) {echo 'selected';}?>>已过期</option>
						  			<option value="3" <?php if($list->contract_condition == 3) {echo 'selected';}?>>历史客户</option>
								</select>
						  	</div>						  	
					    </div>

					    <div class="modal-body">
					       	<div class="form-group">
						   		<label for="inputEmail3" class="col-sm-2 control-label">合同类型</label>
						    	<select class="form-control" style="width : 200px; margin-left:395px;"   name="contract_type" id="contract_type">
						 			<option value="1" <?php if($list->contract_type == 1) {echo 'selected';}?>>新约</option>
						  			<option value="2" <?php if($list->contract_type == 2) {echo 'selected';}?>>续约</option>
								</select>
						  	</div>						  	
					    </div>



				      	<input name="constract_id"  type="hidden"  id="constract_id" value="<?php echo $list->constract_id;?>">

					    <div class="modal-footer">
					        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="javascript:history.back(-1);">关闭</button>
					        <button type="button" class="btn btn-primary" onclick="updateconstract()">修改</button>
					    </div>
			      	</form>
				</div>
	        </div>
      	</div>
    </div>
<script type="text/javascript">
	function updateconstract(){	
		$.post("/sysconstract/updateActive", 
			$("#clientedit").serialize(),
			function(data){			
				if (data.status==0) {
					alert(data.info);
					return ;
				}
				if (data.status==1) {
					alert(data.info);
					window.location.href="/sysconstract/clientConstract/<?php echo $list->client_id; ?>";
				}
				
			},
			'json');
	}
	
</script>
</body>
</html>