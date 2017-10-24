<!DOCTYPE html>
<html lang="zh-CN"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="http://v3.bootcss.com/favicon.ico">

    <title>市场渠道表|系统设置|后台管理系统</title>

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
    <script charset="utf-8" src="clientResource/js/zh_CN.js"></script>

<!--编辑器结束-->
</head>
<body>
<?php $this->load->view('manage/header');?>
    <div class="container-fluid">
        <div class="container-fluid">
          <div class="row">
            <?php $this->load->view('manage/menu');?>        
            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
              <h3 class="page-header"><a href="">小朋友信息</a></h3>
              <div class="table-responsive">
                <table class="table table-striped table-condensed">
                  <thead>
                    <tr>                      
                      <th width="">小朋友姓名</th>
                      <th width="">助记码</th>
                      <th width="">客户编号</th>
                      <th width="">客户类型</th>
                      <th width="">性别</th>
                      <th width="">昵称</th>
                      <th width="">生日</th>
                      <th width="">年龄</th>
                      <th width="">状态</th>
                      <th width="20%">操作</th>
                    </tr>
                  </thead>
                  <tbody id="advertListTbody" >
                    <?php foreach ($list as $v) { ?>
                    <tr>
                      <td width=""><?php echo $v->child_name?></td>
                      <td width=""><?php echo $v->shot_name?></td>
                      <td width=""><?php echo $v->client_no?></td>
                      <td width=""><?php echo $v->customer_type?></td>
                      <td width=""><?php echo $v->child_sex?></td>
                      <td width=""><?php echo $v->nickname?></td>
                      <td width=""><?php echo $v->brithday?></td>
                      <td width=""><?php echo $v->child_age?></td>
                      <td width=""><?php if($v->is_ban == 1){ echo '正常';}elseif($v->is_ban == 2){ echo "挂起";}?></td>
                      
                      <td width="" >                                              
                      <button type="button" class="btn btn-success btn-sm" onclick="javascript:window.location.href='<?php echo site_url("/syschild/updateChild/$v->child_id")?>'">修改</button>                  
                      <button type="button" class="btn btn-danger btn-sm" onclick="delchild(<?php echo $v->child_id;?>)" >删除</button> 

                      </td> 
                    </tr>                                   
                    <?php } ?>  

                  </tbody> 
                </table>
              </div>
              <div>
                <?php echo $links; ?>          
              </div>                    
            </div>
          </div>
        </div>
    </div>
</body>
<script type="text/javascript">    
    function delchild(id){ 
      if (confirm('确定要删除吗？')==false)
      {   
            return false;
      }
      $.post("/syschild/delChild", 
      {id : id},
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
</html>