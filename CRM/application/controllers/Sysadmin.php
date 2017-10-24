<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once $_SERVER['DOCUMENT_ROOT']."/application/utils/function.php";
require_once $_SERVER['DOCUMENT_ROOT']."/application/utils/Excel.class.php";
/**
 * 
 * 系统功能相关操作
 * 1.系统默认页
 * 2.加载联动数据页
 * @author tangjw
 *
 */

class Sysadmin extends AdminBase {
	function  __construct()
	{
		parent::__construct();
	}
	//系统板块默认页
	function index(){
		$data['menu_left'] = $this->menu_left;
		
		//获取所有的联动类型
		$this->load->model("Cascade_model" ,"ccm");
		$ccdTypeArr = $this->ccm->getCcdTypes();
		$data['sysInfo'] = $this->sysInfo;
		$data['ccdTypeArr'] = $ccdTypeArr;
		$this->load->view('manage/system_index', $data);
	}
	//打开系统配置页面
	function sysconfig(){
		$data['menu_left'] = $this->menu_left;

		$this->load->model("system_config_model" ,"scm");
		$config=$this->scm->getdata();
		$data["config"]=$config;

		$this->load->view('manage/system_config', $data);


	}
	//修改系统配置
	function update(){

		$value = $this->input->post("value");

		$sql="update `job_sysconfig` set `value`='".$value."' where id=".$this->uri->rsegment(3);
	
		$rs = $this->db->query($sql);
		$result=$this->db->affected_rows();

	    if($result == 1){
			ajaxreturn("","修改成功！");
	    }else{
			ajaxreturn("","未做修改！",0);
	    }

	}


	//导出登录信息
	function exportlogin(){
		$this->db->select('id,pc_logdate,pc_logtimes,ios_logdate,ios_logtimes,android_logdate,android_logtimes,wap_logdate,wap_logtimes');
		$query = $this->db->get('job_regist_user');
		$res=$query->result();
		$row=array();
		$row[0]=array('用户ID','PC端最后登陆时间','PC端登陆次数','iOS端最后登陆时间','iOS端登陆次数','Andriod端最后登陆时间','Andriod端登陆次数','WAP端最后登陆时间','WAP端登陆次数');
		$i=1;
		foreach($res as $v){
			$row[$i]['id'] = $v->id;
			$row[$i]['pc_logdate'] = date("Y-m-d H:i:s",$v->pc_logdate);
			$row[$i]['pc_logtimes'] = $v->pc_logtimes;
			$row[$i]['ios_logdate'] = date("Y-m-d H:i:s",$v->ios_logdate);
			$row[$i]['ios_logtimes'] = $v->ios_logtimes;
			$row[$i]['android_logdate'] = date("Y-m-d H:i:s",$v->android_logdate);
			$row[$i]['android_logtimes'] = $v->android_logtimes;
			$row[$i]['wap_logdate'] = date("Y-m-d H:i:s",$v->wap_logdate);
			$row[$i]['wap_logtimes'] = $v->wap_logtimes;
			
			$i++;
		}
		$xls = new Excel_XML('UTF-8', false, 'logininfo');
		$xls->addArray($row);
		$xls->generateXML("logininfo");
	}

	function registerAdd(){
		$data['menu_left'] = $this->menu_left;
        $mem = new Memcache;
		$mem->connect('127.0.0.1',11211);
		$data['mem'] =  $mem;
		$data['cityArr'] =  $mem->get('ccdType_19');//城市
		$data['bussArr'] =  $mem->get('ccdType_26');//行业领域
		$data['workExpcArr'] =  $mem->get('ccdType_27');//工作经验
		$data['degreeArr'] = $mem->get('ccdType_28');//学历
		$data['salaryArr']=  $mem->get('ccdType_20');//薪资要求
		$data['statusArr'] = $mem->get('ccdType_34');//简历状态
		$data['majorCcdArr']=  $mem->get('ccdType_25');//职位专业

		$this->load->view('manage/system_registerAdd', $data);
	}
	function doRegisterAdd(){
        $mem = new Memcache;
		$mem->connect('127.0.0.1',11211);
		$data['tel_num'] = $this->input->post("tel_num");
		$query = $this->db->get_where('job_regist_user', array('tel_num' => $data['tel_num']));
    	if($query->num_rows() > 0 ){
    		echo "<script>alert('手机号已存在');history.go(-1);</script>";
    		exit;
    	}
		$data['password'] = md5('renym'.$this->input->post("password").'linximeng');
		
		$data['is_checked'] = 1;
		$data['reg_date'] = date("Y-m-d H:i:s",time());
		$data['reg_source'] = 1;
		$data['name'] = $this->input->post("name");

		$this->db->insert("job_regist_user" , $data);
		if ($this->db->insert_id()) {
			echo "<script>alert('添加成功');window.location.href='/sysadmin/registerAdd';</script>";
			exit;
		}else{

			echo "<script>alert('添加失败');window.location.href='/sysadmin/registerAdd';</script>";
			exit;
		}
	}
}