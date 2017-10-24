<!DOCTYPE html>

<html lang="zh-CN"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="http://v3.bootcss.com/favicon.ico">

    <title>用户组列表|系统设置|后台管理系统</title>

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
    <script src="<?php echo site_url("/managResource/js/sysuseracl.js")?>"></script>
    <!-- 图片上传组件样式及js -->
    <link href="managResource/css/systemFind.css" rel="stylesheet">
    <script type="text/javascript" src="managResource/js/systemFind.js"></script>
  </head>

  <body>
	   
     <?php $this->load->view('manage/header');?>

    <div class="container-fluid">
      <div class="row">
		  <?php $this->load->view('manage/menu');?>
		 
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h3 class="page-header"><a href="<?php echo site_url("/sysacl")?>">用户组管理</a></h3>
          <div class="system_advert_nav">	
          	  <div>
          	  		<a href="/sysacl/add"><button type="button" class="btn btn-success">新增用户组</button></a>
          	  </div>
              

          </div>
          <div class="table-responsive">
            <table class="table table-striped table-condensed">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>用户组</th>
                  <th>管辖范围说明</th>
				          <th>操作</th>
                </tr>
				
              </thead>
              <tbody id="advertListTbody" >
                   <!-- 广告列表内容 -->
                    
              </tbody>

			  
            </table>

          </div>
          <script type="text/javascript">
              getActiveByParam(<?php echo $page; ?>,<?php echo $page_totle; ?>,<?php echo $per_page; ?>);
          </script>

		  <div>
					共<?php echo $page_totle; ?>页 当前 第<?php echo $page; ?>页

					<?php if($page_totle==1){ ?>
								已是最后一页
					<?php } elseif($page<=1){ ?>
						<a href="/sysacl/index/<?php echo $page+1; ?>">下一页</a>&nbsp; 已到达第一页
					<?php } elseif($page>=$page_totle) {?>
						<a href="/sysacl/index/<?php echo $page-1; ?>">上一页</a> &nbsp;已到达最后一页
					
					<?php }else{ ?>
						<a href="/sysacl/index/<?php echo $page-1; ?>">上一页</a>&nbsp;&nbsp;<a href="/sysacl/index/<?php echo $page+1; ?>">下一页</a>
					<?php } ?>
					
			  </div>
        </div>
      </div>
    </div>
    
<!-- 预览广告的模态对话框 -->
</body>
</html>