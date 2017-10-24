<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//error_reporting(E_ALL^E_NOTICE^E_WARNING);
require_once $_SERVER['DOCUMENT_ROOT'].'/application/utils/PhpWord/PhpWord.php'; // 包含头文件
use PhpOffice\PhpWord\Autoloader;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\IOFactory;
 
require_once $_SERVER['DOCUMENT_ROOT'].'/application/utils/PhpWord/Autoloader.php';
Autoloader::register();
Settings::loadConfig();
require_once $_SERVER['DOCUMENT_ROOT']."/application/utils/function.php";
require_once $_SERVER['DOCUMENT_ROOT']."/application/utils/Encryption.php";
	

/**
 * 
 * 客户端公用controller
 * @author tangjw
 *
 */
class My_Controller extends CI_Controller{
		function __construct(){
            parent::__construct();
		}
}
class My_Client_Controller extends My_Controller{
	
	  //判断邮箱和手机号的正则表达式常量
	   const regEmail = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
	   const regTelnum = '/^(0|86|17951)?(13[0-9]|17[0-9]|15[012356789]|18[0-9]|14[57])[0-9]{8}$/';
	   
	   var $rigUser ;
       function __construct() 
       {
            parent::__construct();
            $this->load->helper('url');
		    //加载session,获取session保存的注册用户
	        $this->load->library('session');
            $this->load->library('user_agent');
	        $rigUser = $this->session->userdata('rigUser');

	        if($rigUser == NULL){
	        	$this->load->helper('cookie');
					//将邀约ID和邀约验证码加密
				$encry = new Encryption();
				$rigUserId =get_cookie("one_week_sign_free");
				if($rigUserId != NULL){
					$rigUserId = $encry->decode($rigUserId)   ;
					$this->load->model('Regist_user_model','rum');
					$rigUser = $this->rum->getRegisterById($rigUserId);
							//登录成功，查找是求职者用户还是企业用户
					$rigUser ->curUser = null ;
					 //求职者用户
					 if($rigUser->type == 0 ){
					 	 $this->load->model('Seeker_base_model','sbm');
					 	 $seeker = $this->sbm->getBaseInfoByUid($rigUser->id);
					 	 
					 	 //给当前用户rigUser动态添加一个变量存储
					 	 $rigUser ->curUser = $seeker;
			
					 //企业用户	 
					 }else if($rigUser->type == 1){
					 	 $this->load->model('Company_base_model','cbm');
					 	 $company = $this->cbm->getBaseInfoByUid($rigUser->id);
					 	 
					 	 //给当前用户rigUser动态添加一个变量存储
					 	 $rigUser ->curUser = $company;		
					 }
					 
					 //将登录用户放入session中
					 $this->load->library('session');
					 $sessionData = array("rigUser" => $rigUser);
					 $this->session->set_userdata($sessionData);
				 }
	          }
           $this->rigUser =  $rigUser;
       }
       
       
    //根据用户简历信息生成WORD文档
	function getResumeDoc($seekerId){
		 //加载内存缓存对象 ， 读取内存中的缓存级联内容
        $mem = new Memcache;
		$mem->connect('127.0.0.1',11211);
		$data['mem'] =  $mem;
			
		//查询简历基本信息，包括期望工作和附加信息
         $this->load->model("Seeker_base_model" ,"sbm");
         $seekerBaseInfo = $this->sbm->getBaseInfoById($seekerId);
         
         //转换级联数据
         $seekerBaseInfo->edu_backgroud = $mem->get("ccdContent_".$seekerBaseInfo->edu_backgroud);
         $seekerBaseInfo->work_year = $mem->get("ccdContent_".$seekerBaseInfo->work_year);
         $seekerBaseInfo->city = $mem->get("ccdContent_".$seekerBaseInfo->city);
         $seekerBaseInfo->status = $mem->get("ccdContent_".$seekerBaseInfo->status);
         $seekerBaseInfo->expect_work_industry = $mem->get("ccdContent_".$seekerBaseInfo->expect_work_industry);
         $seekerBaseInfo->expect_work_city = $mem->get("ccdContent_".$seekerBaseInfo->expect_work_city);
         $seekerBaseInfo->expect_work_salary = $mem->get("ccdContent_".$seekerBaseInfo->expect_work_salary);
         //查询工作经历信息
         $this->load->model("Seeker_work_expc_model" ,"swem");
         $workExpcArr = $this->swem->getAllWorkExpc($seekerId , 1);
         
         //查询教育经历
         $this->load->model("Seeker_education_model" ,"sem");
         $educationArr = $this->sem->getAllEducation($seekerId);
         
         //查询项目经验
         $this->load->model("Seeker_project_model" ,"spm");
         $projectArr = $this->spm->getAllProject($seekerId);
         
        //查询语言能力
         $this->load->model("Seeker_skill_model" ,"ssm");
         $skillArr = $this->ssm->getAllSkill($seekerId);
         
         //开始创建word文档
			$phpWord = new \PhpOffice\PhpWord\PhpWord();

			$section = $phpWord->addSection();
			$paragraphStyle = array('align' => 'center');
			$phpWord->addParagraphStyle('pStyle', $paragraphStyle);
			
			$section->addImage('clientResource/images/wordlogo.png' , 
				array(
		        'marginTop' => 0,
		        'marginLeft' => 0,
		        'wrappingStyle' => 'behind',
				'align'=>'center'
		      )
		    );
		   $section->addTextBreak(2);
		   //姓名,个人基本信息
		   if($seekerBaseInfo->photo != "" && $seekerBaseInfo->photo !=NUll){
		   	   $section->addImage('uploads/seeker/headPortrait/'.$seekerBaseInfo->photo , 
								array(
								 'width' => 280,
      						    'height' => 280,
						        'marginTop' => 10,
						        'marginLeft' => 0,
						        'wrappingStyle' => 'behind',
								'align'=>'center'
						      )
		    );
		   }
		   $section->addText(
				     htmlspecialchars($seekerBaseInfo->name),
		            array('name' => 'Tahoma', 'size' => 16, 'color' => '1B2232', 'bold' => true),
		            $paragraphStyle
				    );
			$section->addTextBreak(1);	    
		   $section->addText(
				     htmlspecialchars($seekerBaseInfo->description),
		            array('name' => 'Tahoma', 'size' => 10, 'color' => '1B2232'),
		            $paragraphStyle
				    );
		    $section->addTextBreak(1);	    
		    $section->addText(htmlspecialchars('︳'.$seekerBaseInfo->edu_backgroud.' ︳ '.$seekerBaseInfo->work_year.'  ︳ '.$seekerBaseInfo->city.''),
		            array('name' => 'Tahoma', 'size' => 10, 'color' => '1B2232'),
		            $paragraphStyle
				    );		    
			$section->addTextBreak(1);	    
		   $section->addText(
				     htmlspecialchars( ''.$seekerBaseInfo->telnum.' ︳'.$seekerBaseInfo->email.''),
		            array('name' => 'Tahoma', 'size' => 10, 'color' => '1B2232'),
		            $paragraphStyle
				    );	
			$section->addTextBreak(3);	
			
			//分割线
			$section->addImage('clientResource/images/wordLine.png' , array('align'=>'center' ) );
		    $section->addTextBreak(1);
		     //期望工作
		    $section->addImage('clientResource/images/wordTip.png' , 
				array(
				    'width' => 10,
		            'height' => 30,
				    'wrappingStyle' => 'square',
				    'positioning' => 'absolute',
				    'posHorizontalRel' => 'margin',
				    'posVerticalRel' => 'line'
		      )
		    );
		    $section->addText(htmlspecialchars('期望工作'),array('name' => 'Tahoma', 'size' => 12, 'color' => '1B2232', 'bold' => true) );
		    $section->addTextBreak(1);
   		    $section->addText(htmlspecialchars($seekerBaseInfo->expect_work_industry.' ︳ '.$seekerBaseInfo->expect_work_position.'  ︳ '.$seekerBaseInfo->expect_work_city.'|'.$seekerBaseInfo->expect_work_salary),
			            array('name' => 'Tahoma', 'size' => 10, 'color' => '1B2232')
		                );
	    	$expect_work_other = $seekerBaseInfo->expect_work_other;
//			$expect_work_other = str_replace( '<span style="line-height:1.5;">', '' , $expect_work_other);
            $expect_work_other = str_replace( '<br>', '<br/>' , $expect_work_other);
			\PhpOffice\PhpWord\Shared\Html::addHtml($section, $expect_work_other);
		
			//分割线
			$section->addImage('clientResource/images/wordLine.png' , array('align'=>'center' ) );
		    $section->addTextBreak(1);
		     //工作经验	
		    $section->addImage('clientResource/images/wordTip.png' , 
				array(
				    'width' => 10,
		            'height' => 30,
				    'wrappingStyle' => 'square',
				    'positioning' => 'absolute',
				    'posHorizontalRel' => 'margin',
				    'posVerticalRel' => 'line'
		      )
		    );
		    $section->addText(htmlspecialchars('工作经验'),array('name' => 'Tahoma', 'size' => 12, 'color' => '1B2232', 'bold' => true) );
		   $section->addTextBreak(1);
			foreach ($workExpcArr as $workExpc){
			 	$table = $section->addTable();
		        $table->addRow(400);
				$table->addCell(5000)->addText(htmlspecialchars($workExpc->company_name, ENT_COMPAT, 'UTF-8'),
			                          array('name' => 'Tahoma', 'size' => 10, 'color' => '1B2232', 'bold' => true));
				$table->addCell(2000)->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'));
				
				$table->addRow(400);
				$table->addCell(5000)->addText(htmlspecialchars($workExpc->position, ENT_COMPAT, 'UTF-8'));
				$table->addCell(2000)->addText(htmlspecialchars($workExpc->work_time_begin."--".$workExpc->work_time_end, ENT_COMPAT, 'UTF-8'));
			
				$work_content = $workExpc->work_content;
//				$work_content = str_replace( '<span style="line-height:1.5;">', '' , $work_content);
				$work_content = str_replace( '<br>', '<br/>' , $work_content);
				
				\PhpOffice\PhpWord\Shared\Html::addHtml($section, $work_content);
			 }
			 
				//分割线
			$section->addImage('clientResource/images/wordLine.png' , array('align'=>'center' ) );
		    $section->addTextBreak(1);
		     //教育经历	
		    $section->addImage('clientResource/images/wordTip.png' , 
				array(
				    'width' => 10,
		            'height' => 30,
				    'wrappingStyle' => 'square',
				    'positioning' => 'absolute',
				    'posHorizontalRel' => 'margin',
				    'posVerticalRel' => 'line'
		      )
		    );
		    $section->addText(htmlspecialchars('教育经历'),array('name' => 'Tahoma', 'size' => 12, 'color' => '1B2232', 'bold' => true) );
		   $section->addTextBreak(1);
			foreach ($educationArr as $education){
			 	$table = $section->addTable();
		        $table->addRow(400);
				$table->addCell(5000)->addText(htmlspecialchars($education->college_name, ENT_COMPAT, 'UTF-8'),
			                          array('name' => 'Tahoma', 'size' => 10, 'color' => '1B2232', 'bold' => true));
				$table->addCell(2000)->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'));
				
				$table->addRow(400);
				$table->addCell(5000)->addText(htmlspecialchars($education->major ."|".$education->degree , ENT_COMPAT, 'UTF-8'));
				$table->addCell(2000)->addText(htmlspecialchars($education->edu_date_begin."--".$education->edu_date_end, ENT_COMPAT, 'UTF-8'));
			
			 }
			 
			//分割线
			$section->addImage('clientResource/images/wordLine.png' , array('align'=>'center' ) );
		    $section->addTextBreak(1);
		     //项目经验	
		    $section->addImage('clientResource/images/wordTip.png' , 
				array(
				    'width' => 10,
		            'height' => 30,
				    'wrappingStyle' => 'square',
				    'positioning' => 'absolute',
				    'posHorizontalRel' => 'margin',
				    'posVerticalRel' => 'line'
		      )
		    );
		    $section->addText(htmlspecialchars('项目经验	'),array('name' => 'Tahoma', 'size' => 12, 'color' => '1B2232', 'bold' => true) );
		   $section->addTextBreak(1);
			foreach ($projectArr as $project){
			 	$table = $section->addTable();
		        $table->addRow(400);
				$table->addCell(5000)->addText(htmlspecialchars($project->name, ENT_COMPAT, 'UTF-8'),
			                          array('name' => 'Tahoma', 'size' => 10, 'color' => '1B2232', 'bold' => true));
				$table->addCell(2000)->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'));
				
				$table->addRow(400);
				$table->addCell(5000)->addText(htmlspecialchars($project->duty, ENT_COMPAT, 'UTF-8'));
				$table->addCell(2000)->addText(htmlspecialchars($project->date_begin."--".$project->date_end, ENT_COMPAT, 'UTF-8'));
			
				$work_content = $project->description;
//				$work_content = str_replace( '<span style="line-height:1.5;">', '' , $work_content);
                $work_content = str_replace( '<br>', '<br/>' , $work_content);
				
				\PhpOffice\PhpWord\Shared\Html::addHtml($section, $work_content);
			 }	 
			//分割线
			$section->addImage('clientResource/images/wordLine.png' , array('align'=>'center' ) );
		    $section->addTextBreak(1);

		     //附加信息
		    $section->addImage('clientResource/images/wordTip.png' , 
				array(
				    'width' => 10,
		            'height' => 30,
				    'wrappingStyle' => 'square',
				    'positioning' => 'absolute',
				    'posHorizontalRel' => 'margin',
				    'posVerticalRel' => 'line'
		      )
		    );
		    $section->addText(htmlspecialchars('附加信息	'),array('name' => 'Tahoma', 'size' => 12, 'color' => '1B2232', 'bold' => true) );
    		$extra_message = $seekerBaseInfo->extra_message;
//			$extra_message = str_replace( '<span style="line-height:1.5;">', '' , $extra_message);
            $extra_message = str_replace( '<br>', '<br/>' , $extra_message);			
			\PhpOffice\PhpWord\Shared\Html::addHtml($section, $extra_message);
   	
			// Saving the document as OOXML file...
			$fileName = $_SERVER['DOCUMENT_ROOT']."/downloads/seeker/resume/".$seekerBaseInfo->id.uniqid().".docx" ;
			$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
			$objWriter->save($fileName);
			return array('resumeName'=>$seekerBaseInfo->name , 'fileName'=>$fileName );
	}
	
	
	//客户端返回操作信息简单弹出窗口
	function singleAlert($msg , $funcBackUrl){
			echo "<link href='/clientResource/css/Common.css' rel='stylesheet' />
			     <script type='text/javascript' src='/clientResource/js/jquery-2.1.4.min.js'></script>
			     <script type='text/javascript' src='/clientResource/js/commonAlert.js'></script>
			     <style type='text/css'>body{ margin: 0;padding: 0;}</style>
			     <script type='text/javascript'>
                        function func(){
                              window.location.href='".$funcBackUrl."';
                          }
			     </script>
			     <div class='commonAlert_1'><div class='commonContent'  id='commonAlert'><p>$msg</p><div><button class='commonAlertStyle1' onclick='func();'>确定</button></div></div></div>";
	}
	
	//移动端返回操作信息简单弹出窗口
	function mbSingleAlert($msg , $funcBackUrl){
		echo "<meta name='viewport' content='width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no'>
		<meta name='apple-mobile-web-app-capable' content='yes' />    
		<meta name='apple-mobile-web-app-status-bar-style' content='black-translucent' />
		<meta name='format-detection' content='telephone=yes'/>
		<meta name='msapplication-tap-highlight' content='no' />
		         <link href='/mobileResource/css/header.css' rel='stylesheet' />
		         <link href='/mobileResource/css/Reset.css' rel='stylesheet' />
			     <script type='text/javascript' src='/mobileResource/js/zepto.min.js'></script>
			     <script type='text/javascript' src='/mobileResource/js/mobileAlert.js'></script>
			     <style type='text/css'>body{ margin: 0;padding: 0;}</style>
			     <script type='text/javascript'>
                        function func(){
                              window.location.href='".$funcBackUrl."';
                          }
			     </script>
				<div class='mobileAlertCover'>
				        <div class='mobileAlertContent'>
				        <div class='alertText iptSection'>$msg</div>
				          <a class='alertButton iptSection' onclick='func();'>确定</a>
				        </div>
				</div>
			        ";
	}

	//客户端返回操作信息简单弹出窗口并返回前一页
	function AlertGotohistory($msg){
			echo "<link href='/clientResource/css/Common.css' rel='stylesheet' />
			     <script type='text/javascript' src='/clientResource/js/jquery-2.1.4.min.js'></script>
			     <script type='text/javascript' src='/clientResource/js/commonAlert.js'></script>
			     <style type='text/css'>body{ margin: 0;padding: 0;}</style>
			     <script type='text/javascript'>
                        function func(){
                              history.go(-1);
                          }
			     </script>
			     <div class='commonAlert_1'><div class='commonContent'  id='commonAlert'><p>$msg</p><div><button class='commonAlertStyle1' onclick='func();'>确定</button></div></div></div>";
	}
	
	
	//发送邮件消息
	function sendEmailMsg($toEmail , $subject , $message){
		//以下设置Email内容  ，发送邮件
			/*$this->load->library('email');                 //加载CI的email类   	
			$this->config->load('email');        
			$smtpUser = $this->config->item('smtp_user');
		    $emailName = $this->config->item('email_name');        
	        $this->email->from($smtpUser, $emailName); 
			$this->email->to($toEmail);  
			$this->email->subject($subject);  
			$this->email->message($message);  
			//附件，相对于index.php的路径  	
			//$this->email->attach('application\controllers\1.jpeg');            
			$this->email->send(); */

		header("content-type:text/html;charset=utf-8");
		require_once $_SERVER['DOCUMENT_ROOT']."/application/utils/phpmailer/class.phpmailer.php";
		try {
			$mail = new PHPMailer(true); 
			$mail->IsSMTP();
			$mail->CharSet='UTF-8'; //设置邮件的字符编码，这很重要，不然中文乱码
			$mail->SMTPAuth   = true;                  //开启认证
			$mail->Port       = 465;                    
			$mail->Host       = "ssl://smtp.qq.com"; 
			$mail->Username   = "";    
			$mail->Password   = "";
			//$mail->IsSendmail(); //如果没有sendmail组件就注释掉，否则出现“Could  not execute: /var/qmail/bin/sendmail ”的错误提示
			$mail->AddReplyTo("");//回复地址
			$mail->From       = "";
			$mail->FromName   = "";
			$mail->AddAddress($toEmail);
			$mail->Subject  = $subject;
			$mail->Body = $message;
			//$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; //当邮件不支持html时备用显示，可以省略
			//$mail->WordWrap   = 80; // 设置每行字符串的长度
			//$mail->AddAttachment("f:/test.png");  //可以添加附件
			$mail->IsHTML(true); 
			$mail->Send();
			//echo '邮件已发送';
		} catch (phpmailerException $e) {
			//echo "邮件发送失败：".$e->errorMessage();
		}

	}
	
	//发送手机短信信息
	function sendTelMsg($toTelNum , $content){
			if(!preg_match( $this::regTelnum, $toTelNum )){
				return  "{\"error\" : \"telnum_wrong\"}"; 
		    }
			$ch = curl_init();
		     $url = 'http://apis.baidu.com/kingtto_media/106sms/106sms?mobile='.$toTelNum.'&content='.urlencode($content).'&tag=2';
		    $header = array(
		        'apikey: 8fbcbe2c70f95395390715da34b43822',
		    );
		    // 添加apikey到header
		    curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    // 执行HTTP请求
		    curl_setopt($ch , CURLOPT_URL , $url);
		    $res = curl_exec($ch);
		    return $res ; 
	}
}


 
class AdminBase extends My_Controller
{
	function  __construct()
	{
		parent::__construct();
		$this->load->helper('url');
	    //加载session,获取session保存的注册用户信息,注册用户ID
        $this->load->library('session');
        $this->load->library('user_agent');
        $this->sysInfo = $this->session->userdata();
        /*var_dump($this->session->userdata());
        exit;*/
        //﻿array(1) { ["__ci_last_regenerate"]=> int(1470214892) }
        if(@$this->sysInfo["systemUserId"] == NULL){
        	echo "<script type='text/javascript'>window.location.href='".site_url("/Manager")."'</script>";
        	exit;
        }
        
        //获取方法名
		$model=$this->uri->rsegment(1);
		$action=$this->uri->rsegment(2);
		//查询当前用户所属用户组
		$this->db->select('u_group_id');
		$query = $this->db->get_where('job_system_user', array('id' => $this->sysInfo["systemUserId"]));
		//查询用户组拥有的权限
		$queryacl = $this->db->get_where('job_system_useracl', array('id' => $query->row()->u_group_id));

		$acl=unserialize($queryacl->row()->controller);
		$inc = useracl();
		if (@array_keys($acl[$model],$inc[0]["low_leve"][$model]["data"]['eqaction_'.$action])==null) {
			echo "<script type='text/javascript'>alert('访问地址错误或无权限访问！');window.location.href='".site_url("/Manager")."'</script>";
			exit;
		}
		
  
		$menu_left=adminmenu();
		foreach ($menu_left as $key => $menu_1) {
			foreach($menu_1['low_title'] as $key2 => $menu_2) {
				foreach($menu_1[$key2] as $key3 => $menu_3) {
					
					if(@$acl[$menu_3[1]] == null || array_keys($acl[$menu_3[1]],$inc[0]["low_leve"][$menu_3[1]]["data"]['eqaction_'.$menu_3[2]])==null){
						unset($menu_left[$key][$key2][$key3]);
					}

				}
					if ($menu_left[$key][$key2]==null) {
						unset($menu_left[$key][$key2]);
						unset($menu_left[$key]['low_title'][$key2]);
					}
			}
		}
		$this->menu_left=$menu_left;

	}
}