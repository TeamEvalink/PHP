<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once $_SERVER['DOCUMENT_ROOT']."/application/utils/CheckCode.php";
require_once $_SERVER['DOCUMENT_ROOT']."/application/utils/function.php";

/**
 * 
 * 后台管理相关操作
 * 1.获取验证码
 * 2.管理后台默认登录页
 * 3.登录
 * 4.退出
 * 
 * @author tangjw
 *
 */

class Manager extends CI_Controller {
	
	
	//管理后台默认系统页
	function  index(){
		$this->load->helper('url');
	    //加载session,获取session保存的注册用户信息,注册用户ID
        $this->load->library('session');
        $sysUserId = $this->session->userdata('systemUserId');
        if($sysUserId == NULL){
        	$this->load->view('manage/login.php');
        }else{
        	echo "<script type='text/javascript'> window.location.href='".site_url("/sysadmin/index")."'</script>";
        }
	}
	
	//登录
	function signIn(){
		$this->load->helper('url');
		$this->load->library('session');
		
		$identifyCode = $this->input->post("identifyCode");
		$serverIdentifyCode = $this->session->userdata('identifyCode');
		if(strtolower($identifyCode) != strtolower($serverIdentifyCode)){
			echo "<script type='text/javascript'> alert('验证码错误,请重新登录！');window.location.href='".site_url("/Manager")."'</script>";
			exit();
		}
		
		$account = $this->input->post("account");
		$pwd = $this->input->post("password");
		
		$this->load->model('System_user_model','sum');
		$this->sum->account = $account ; 
		$this->sum->password = md5($pwd) ;

		$result = $this->sum->loginCheck();
		if($result != 0 ){
			//登录成功，返回系统页
			 $this->load->library('session');
			 $last_log_time=time();
			 $last_log_ip=get_client_ip();
			 $this->sum->updateUserInfo($result,$last_log_time,$last_log_ip);
			 $sessionData = array("systemUserId" => $result,
			                      "systemUserAcount"=>$account);
			 $this->session->set_userdata($sessionData);
			 //echo "<script type='text/javascript'> window.location.href='".site_url("/sysadmin")."'</script>";
			 redirect(site_url("/sysadmin/index"), 'refresh');
		}else{
			echo "<script type='text/javascript'> alert('用户名或密码错误,请重新登录！');window.location.href='".site_url("/Manager")."'</script>";
		}
		
		
	}
	
	//退出
	function logOut(){
		$this->load->helper('url');
		$this->load->library('session');
		//或者批量删除
		$sessionData = array("systemUserId" , "systemUserAcount");
		$this->session->unset_userdata($sessionData);
		echo "<script type='text/javascript'> window.location.href='".site_url("/Manager")."'</script>";
		
		
	}
	
	//获取验证码
	function getIdentifyCode(){
	       //加载session,获取session保存的注册用户信息,注册用户ID
		    $this->load->library('session');
			$checkCoder = new CheckCode();
			$checkCoder->create();
			$this->session->set_userdata('identifyCode', $checkCoder->randnum);
			
	}
	



}