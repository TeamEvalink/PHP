<!DOCTYPE html>
<html lang="zh-CN"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="http://v3.bootcss.com/favicon.ico">

    <title>联系记录|系统设置|后台管理系统</title>

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
              <h3 class="page-header"><a href="<?php echo site_url("/sysclient/child/$client_id")?>">联系记录</a></h3>
              <button type="button" class="btn btn-success btn-sm" onclick="javascript:window.location.href='<?php echo site_url("/sysconnect/addconnect/$client_id")?>'">新增联系记录</button>
              <button type="button" style="margin-left: 10%;" class="btn btn-warning btn-sm" data-dismiss="modal" onclick="javascript:window.location.href='<?php echo site_url("/sysclient/index")?>'">返回</button>
              <div class="table-responsive">
                <table class="table table-striped table-condensed">
                  <thead>
                    <tr>                      
                      <th width="">联系人</th>
                      <th width="">联系电话</th>
                      <th width="">联系内容</th>
                      <th width="">联系日期</th>
                      <th width="">是否联系</th>
                      <th width="">联系结果</th>
                      <th width="">操作</th>
                    </tr>
                  </thead>
                  <tbody id="advertListTbody" >
                    <?php foreach ($list as $v) { ?>
                    <tr>
                      <td width=""><?php echo $v->connect_name?></td>
                      <td width=""><?php echo $v->connect_tel?></td>
                      <td width=""><?php echo $v->connect_info?></td>
                      <td width=""><?php echo $v->connect_date?></td>
                      <td width=""><?php if($v->is_connect == 1){ echo '未联系';}elseif($v->is_connect == 2){ echo "已联系";}?></td>
                      <td width=""><?php echo $v->connect_result?></td>

                      
                      
                      <td width="" >                                              
                      <button type="button" class="btn btn-success btn-sm" onclick="javascript:window.location.href='<?php echo site_url("/sysconnect/update/$v->connect_id/$v->client_id")?>'">更新联系结果</button>

                      </td> 
                    </tr>                                   
                    <?php } ?>  

                  </tbody> 

                </table>
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
      $.post("/sysclient/delChild", 
      {id : id},
      function(data){     
        if (data.status==0) {
          alert(data.info);
          return ;
        }
        if (data.status==1) {
          alert(data.info);
          window.location.href="/sysclient/child/<?php echo $client_id;?>";
        }        
      },
      'json');    
    }

    function shareclient(id){
      $.post("/sysclient/share", 
      {id : id},
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
</html>