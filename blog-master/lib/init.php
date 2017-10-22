<?php
/**
 * Created by PhpStorm.
 * User: huangbin
 * Date: 2017/4/29
 * Time: 21:48
 */
header("Content-type:text/html;charset=utf-8");
define('ROOT_PATH',dirname(__DIR__) . '/');
define('TMP_PATH',ROOT_PATH . 'template' .'/');
define('LIB_PATH',ROOT_PATH . 'lib' . '/');
define('ADMIN_ROOT_PATH' , dirname(__DIR__) .'/' . 'admin' . '/');
define('ADMIN_TEMPLATE_PATH' , ADMIN_ROOT_PATH . 'template' . '/');
define('ADMIN_LIB_PATH', ADMIN_ROOT_PATH .'lib'. '/');
define('UPLOAD_PATH',ROOT_PATH .'upload' . '/');
require  'DAOMySQLI.php';
$a = [];
$dao = DAOMySQLI::Single($a);

session_start();

//$request_filename = basename($_SERVER['SERVER_NAME']);
//if(!($request_filename == 'user.php' && ($action == 'login'||$action =='check')))
//{
//    if(!isset($_SERVER['user']))
//    {
//        if(isset($_COOKIE['id']) && isset($_COOKIE['password']))
//        {
//            $id = $_COOKIE['id'];
//            $password = $_COOKIE['password'];
//
//            $sql = "select * from user where id = $id and password = $password";
//            $user = $dao->fetchRow($sql);
//            if(!$user)
//            {
//                header('Location : user.php?a=login');
//                die;
//            }
//            else
//            {
//                $_SESSION['user'] = $user;
//            }
//        }
//        else
//        {
//            header('Location: user.php?a=login');
//            die;
//        }
//    }
//}
