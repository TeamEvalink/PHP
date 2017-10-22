<?php
/**
 * Created by PhpStorm.
 * User: huangbin
 * Date: 2017/4/30
 * Time: 16:52
 */
require '../lib/init.php';
$action = isset($_GET['a']) ? $_GET['a'] : 'login';

if($action == 'login')
{
    require ADMIN_TEMPLATE_PATH . 'login.html';
}
elseif($action == 'check')
{
    require LIB_PATH .'Captcha.class.php';
    $tool_captcha = new Captcha();
    if(!$tool_captcha->checkCode($_POST['captcha']))
    {
        header('Refresh : 3 ;URL=user.php?a=login');
        echo 'captcha error';
        die;
    }

    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    if($username == ''|| $password =='')
    {
        die('用户名，密码输入有问题');
    }
    $sql = "select * from user where username = '{$username}'";
    $user = $dao->fetchRow($sql);
//    echo "<pre>";
//    var_dump($user);
    if($user['password'] == $password)
    {
        $_SESSION['user'] = $user;
        if(isset($_POST['remember_me']))
        {
            setcookie('id',$user['id'] ,time()+2*7*24*3600);
            setcookie('password',$user['password'] ,time()+2*7*24*3600);
        }
        require ADMIN_TEMPLATE_PATH .'index.html';
    }

}
elseif($action == 'captcha')
{
    require LIB_PATH .'Captcha.class.php';
    $tool_captcha = new Captcha();
    $tool_captcha->mkimage();
}