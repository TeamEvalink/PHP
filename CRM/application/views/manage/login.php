<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    
    <title>登录|后台管理系统</title>

    <link href="<?php echo site_url("/managResource/bootstrap-3.3.5-dist/css/bootstrap.min.css")?>" rel="stylesheet">
    <link href="<?php echo site_url("/managResource/css/login.css")?>" rel="stylesheet">
    

  </head>
  <body>
    <div class="container">

      <form class="form-signin" action="<?php echo site_url("/Manager/signIn")?>" method="post">
        <h2 class="form-signin-heading">欢迎登录！</h2>
        <label for="inputEmail" class="sr-only">Account</label>
        <input name="account" type="text" id="inputEmail" class="form-control" placeholder="Account" required="" autofocus="">
        <label for="inputPassword" class="sr-only">Password</label>
        <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required="">
        <label for="inputIdentifyCode" class="sr-only">Identify</label>
        <input name="identifyCode" type="text" id="inputIdentifyCode" class="form-control" placeholder="Identify" required="">
        <img id="identifyCodeImg" src="<?php echo site_url("/Manager/getIdentifyCode")?>" width="100px" height="40px" 
          onclick="document.getElementById('identifyCodeImg').src='<?php echo site_url("/Manager/getIdentifyCode")?>'">
        <a onclick="document.getElementById('identifyCodeImg').src='<?php echo site_url("/Manager/getIdentifyCode")?>'"> 换一张</a>
        <button class="btn btn-lg btn-primary btn-block" type="submit">登录</button>
      </form>

    </div> 
  </body>
</html>
