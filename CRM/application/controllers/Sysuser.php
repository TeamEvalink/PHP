<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 管理员的管理操作
 *
 */

class Sysuser extends AdminBase {
	function  __construct()
	{
		$mem = new Memcache;
		$mem->connect('127.0.0.1',11211);
		parent::__construct();

	}
	
	//加载管理员管理首页
	function index(){
			$page = $this->uri->rsegment(3)==""?1:$this->uri->rsegment(3);
			$data['page'] = $page;

			$sql = "select count(*) count from job_system_user";
			$rs = $this->db->query($sql);
			$count = $rs->row()->count;  //查询数据总量
			$per_page = 10;
			$page_totle = ceil($count/$per_page);


			$data['count'] = $count;
			$data['per_page'] = $per_page;
			$data['page_totle'] = $page_totle;

			$data['menu_left'] = $this->menu_left;
			$data['sysInfo'] = $this->sysInfo;
			$this->load->view('manage/system_user', $data);
	}

	//添加活动页面

	function add(){
			
			$data['qxinfo'] = $this->db->get('job_system_useracl')->result();
			$data['menu_left'] = $this->menu_left;
			$this->load->view('manage/system_useradd', $data);
	}


	//添加活动
	function  addActive(){

			$this->load->model("System_user_model" ,"act");
			$this->act->account = $this->input->post("account");
			$this->act->u_group_id = $this->input->post("u_group_id");			
			$this->act->is_ban = $this->input->post("is_ban");
			$this->act->user_name = $this->input->post("user_name");
			$a = $this->act->user_name;
			if ($this->input->post("PASSWORD")!=$this->input->post("repassword")) {
				ajaxreturn("","密码不一致，请重新输入",0);
			}else{
				$this->act->PASSWORD = md5($this->input->post("PASSWORD"));
				unset($this->act->password);
			}
			$result = $this->act->addActive();

			if ($result>=1) {
				ajaxreturn("","员工添加成功！");
			}else{
				ajaxreturn("","员工添加失败！",0);
			}
			
	}

	//根据条件查询相关活动
	function getActiveByParam(){
	
        $this->load->model("System_user_model" ,"act");
		$result = $this->act->getActiveByParam();
			
        echo json_encode($result);
	}

	//管理员修改页面
	function update(){

	        $this->load->model("System_user_model" ,"act");
			$userId = $this->uri->segment(3);
			
			$active_Info = $this->act->getActiveById($userId);
			$data['info'] = $active_Info;
			$data['qxinfo'] = $this->db->get('job_system_useracl')->result();
			$data['menu_left'] = $this->menu_left;
			$this->load->view("manage/system_useredit" , $data);
	}

	//删除管理员
	function deleteActive(){
        $this->load->model("System_user_model" ,"act");
		$userId = $this->input->post("id");

		$result = $this->act->deleteActive($userId);

        echo $result;
	}


		

	//管理员修改执行页面
	function  Act_update(){

			$act_id = $this->input->post("id");

			$this->load->model("System_user_model" ,"act");
			$this->act->account = $this->input->post("account");
			$this->act->user_name = $this->input->post("user_name");
			$this->act->u_group_id = $this->input->post("u_group_id");
			$this->act->is_ban = $this->input->post("is_ban");
			if ($this->input->post("PASSWORD")!=null) {
				$this->act->PASSWORD = md5($this->input->post("PASSWORD"));
			}else{
				unset($this->act->password);
			}
			$result = $this->act->updateActive($act_id);

		   if($result == 1){
				echo '修改成功';
		   }else{
				echo '修改失败';
		   }
	}


}