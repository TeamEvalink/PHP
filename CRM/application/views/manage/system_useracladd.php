<!DOCTYPE html>

<html lang="zh-CN"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="http://v3.bootcss.com/favicon.ico">

    <title>添加用户组权限|系统设置|后台管理系统</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo site_url("/managResource/bootstrap-3.3.5-dist/css/bootstrap.min.css")?>" rel="stylesheet">

    <link href="<?php echo site_url("/managResource/css/dashboard.css")?>" rel="stylesheet">
     <link href="<?php echo site_url("/managResource/css/advert.css")?>" rel="stylesheet">
     <link href="<?php echo site_url("/managResource/bootstrap-datepicker-1.4.0-dist/css/bootstrap-datepicker.css")?>" rel="stylesheet">

    <!-- Bootstrap core JavaScript ========================== -->
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

	<script src="/clientResource/cs_js/ajaxfileupload.js" type="text/javascript"></script>

    <!-- 图片上传组件样式及js -->
    <link href="managResource/css/systemFind.css" rel="stylesheet">
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
          <h3 class="page-header"><a href="<?php echo site_url("/sysacl")?>">账户权限添加</a></h3>
  <div id="form_box">       
      <form class="form-horizontal" id="useracladd" method="post" enctype=”multipart/form-data”>
      <div class="modal-body">
	       <div class="form-group">
		    <label for="inputEmail3" class="col-sm-2 control-label">用户组名称：</label>
		    <div class="col-sm-10">
		      <input name="name"  type="text" class="form-control" id="name" placeholder="用户组名称" value="">
		    </div>
		  </div>
		  
		  <div class="form-group">
		    <label for="inputEmail3" class="col-sm-2 control-label">用户组介绍</label>
		    <div class="col-sm-10">
		      <input name="intro"  type="text" class="form-control" id="intro" placeholder="用户组介绍" value="">
		    </div>
		  </div>
      <?php foreach($acl_list as $ke => $vo){?>
		  <div class="form-group">
		    <label for="inputPassword3" class="col-sm-2 control-label text-danger"><?php echo $vo['low_title']['0'];?></label>
		    <div class="col-sm-10">
		        <input type="checkbox" onclick="select_all('fa<?php echo $ke;?>');" id="fa<?php echo $ke;?>" class="aa" />
            <span for="fa<?php echo $ke;?>">全选</span>
		    </div>
		  </div>
      <?php foreach($vo['low_leve'] as $fmodel => $vs){ ?>
      <?php foreach($vs as $keyname => $item){ ?>
      <?php if($keyname != "data"){ ?>
		   <div class="form-group">
		    <label for="inputPassword3" class="col-sm-2 control-label"><?php echo $keyname;?></label>
		    <div class="col-sm-10">
		           <?php foreach($item as $itemname => $itemkey){ ?>
               <input data="fa<?php echo $ke;?>_son" type="checkbox" name="model[<?php echo $fmodel;?>][]" value="<?php echo $itemkey;?>" id="<?php echo $fmodel;?><?php echo $itemkey;?>">
                    <span for="<?php echo $fmodel;?><?php echo $itemkey;?>"><?php echo $itemname;?></span>
               <?php }?>
		    </div>
		  </div>
      <?php }?>
      <?php }?>
      <?php }?>
      <?php }?>


      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="location.href='/sysacl';">关闭</button>
	        <button type="button" class="btn btn-primary" onclick="adduseracl()">添加</button>
	      </div>
      </form>
</div>
        </div>
      </div>
    </div>


  	<script type="text/javascript">
      function select_all(id) {
        var se = id + "_son";
        if ($("#" + id).prop('checked')) {
          $("input[data=" + se + "]").each(function(i, obj) {
            $(obj).prop('checked', 'true');

          });
        } else {
          $("input[data=" + se + "]").each(function(i, obj) {
            $(obj).prop('checked', '');

          });
        }

      }
  	</script>

</body>
</html>