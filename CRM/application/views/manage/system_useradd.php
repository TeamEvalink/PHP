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
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="<?php echo site_url("/managResource/js/holder.min.js")?>"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="<?php echo site_url("/managResource/js/ie10-viewport-bug-workaround.js")?>"></script>
    <script src="<?php echo site_url("/managResource/js/ie-emulation-modes-warning.js")?>"></script>
    <script src="<?php echo site_url("/managResource/bootstrap-datepicker-1.4.0-dist/js/bootstrap-datepicker.js")?>"></script>

    <script src="<?php echo site_url("/managResource/bootstrap-datepicker-1.4.0-dist/locales/bootstrap-datepicker.zh-CN.min.js")?>"></script>
    <script src="<?php echo site_url("/managResource/js/sysuser.js")?>"></script>

	<script src="/clientResource/cs_js/ajaxfileupload.js" type="text/javascript"></script>

    <!-- 图片上传组件样式及js -->
    <script type="text/javascript" src="managResource/js/systemFind.js"></script>
		<!--编辑器-->
<script charset="utf-8"s src="clientResource/js/kindeditor-all-min.js"></script>
<script charset="utf-8" src="clientResource/js/zh_CN.js"></script>

<!--编辑器结束-->
  </head>

  <body>
	   <?php $this->load->view('manage/header');?>

    <div class="container-fluid">
      <div class="row">
		
		<?php $this->load->view('manage/menu');?>
		
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h3 class="page-header"><a href="<?php echo site_url("/sysuser")?>">新增账户</a></h3>
  <div id="form_box">       
      <form class="form-horizontal" id="useredit" method="post" enctype=”multipart/form-data”>
      <div class="modal-body">
	       <div class="form-group">
		    <label for="inputEmail3" class="col-sm-2 control-label">账户</label>
		    <div class="col-sm-10">
		      <input name="account"  type="text" class="form-control" id="account" placeholder="账户" value="">
		    </div>
		  </div>
		  
		  <div class="form-group">
		    <label for="inputEmail3" class="col-sm-2 control-label">密码</label>
		    <div class="col-sm-10">
		      <input name="PASSWORD"  type="password" class="form-control" id="PASSWORD" placeholder="管理员密码" value="">
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="inputEmail3" class="col-sm-2 control-label">确认密码</label>
		    <div class="col-sm-10">
		      <input name="repassword"  type="password" class="form-control" id="repassword" placeholder="确认管理员密码" value="">
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="inputEmail3" class="col-sm-2 control-label">员工姓名</label>
		    <div class="col-sm-10">
		      <input name="user_name"  type="text" class="form-control" id="user_name" placeholder="员工姓名" value="">
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="inputPassword3" class="col-sm-2 control-label">所属用户组</label>
		    <div class="col-sm-10">
		           <select name="u_group_id" id="u_group_id" class="form-control"  >
						<?php
						foreach ($qxinfo as $key => $val) { ?>

							<option value="<?php echo $val->id; ?>" ><?php echo $val->name; ?></option>

						<?php }?>
					</select>
		    </div>
		  </div>

		   <div class="form-group">
		    <label for="inputPassword3" class="col-sm-2 control-label">是否启用</label>
		    <div class="col-sm-10">
		            <select name="is_ban" id="is_ban" class="form-control"  >
          		      
          		        <option value="1">启用</option>
					    <option value="0">不启用</option>
          		       
          		    </select>
		    </div>
		  </div>

      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="location.href='/sysuser';">关闭</button>
	        <button type="button" class="btn btn-primary" onclick="adduser()">添加</button>
	      </div>
      </form>
</div>
        </div>
      </div>
    </div>

</body>
</html>