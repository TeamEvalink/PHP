<!DOCTYPE html>

<html lang="zh-CN"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="http://v3.bootcss.com/favicon.ico">

    <title>我的信息|系统设置|后台管理系统</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo site_url("/managResource/bootstrap-3.3.5-dist/css/bootstrap.min.css")?>" rel="stylesheet">

    <link href="<?php echo site_url("/managResource/css/dashboard.css")?>" rel="stylesheet">
    <link href="<?php echo site_url("/managResource/css/enter.css")?>" rel="stylesheet">

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
    
    <script src="<?php echo site_url("/managResource/js/cascade.js")?>"></script>
  </head>

  <body>
	   <?php $this->load->view('manage/header');?>

    <div class="container-fluid">
      <div class="row">
		 <?php $this->load->view('manage/menu');?>
		 
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h3 class="page-header">我的信息</h3>
            <!--我的信息-->
            <div class="AuditingInfor">
              <dl class="AuditingInfor_top">
                  <dt><img src="<?php echo site_url("managResource/images/AuditingInfor_pic1.png")?>" /></dt>
                    <dd>用户名：<span><?php echo $sysInfo['systemUserAcount'];?></span><br />工号：<span></span></dd>
                </dl>
                <ul class="AuditingInfor_bottom">
                </ul>
            </div>
        </div>
      </div>
    </div>
</body>
</html>