<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 管理员权限的管理操作
 *
 */

class Sysacl extends AdminBase {
	function  __construct()
	{
		parent::__construct();
	}
	//加载管理员管理首页
	function index(){

			$page = $this->uri->rsegment(3)==""?1:$this->uri->rsegment(3);
			$data['page'] = $page;

			$sql = "select count(*) count from job_system_useracl";
			$rs = $this->db->query($sql);
			$count = $rs->row()->count;  //查询数据总量
			$per_page = 10;
			$page_totle = ceil($count/$per_page);

			$data['count'] = $count;
			$data['per_page'] = $per_page;
			$data['page_totle'] = $page_totle;
			$data['menu_left'] = $this->menu_left;
			//print_r($data['menu_left']);
			//获取$this->router->class

			$this->load->view('manage/system_useracl', $data);
	}

	//添加活动页面

	function add(){
			$data['acl_list'] = useracl();
			$data['menu_left'] = $this->menu_left;
			$this->load->view('manage/system_useracladd', $data);
	}


	//执行添加用户组
	function  addActive(){
			$this->load->model("System_useracl_model" ,"act");
			$data1['name'] = $this->input->post("name");
			$data1['controller'] = serialize($this->input->post("model"));
			$data1['intro'] = $this->input->post("intro");
			$result = $this->act->addActive($data1);
			if ($result>=1){
				ajaxreturn("","用户组添加成功！");
			}else{
				ajaxreturn("","用户组添加失败！",0);
			}
			
	}

	//根据条件查询相关活动
	function getActiveByParam(){
	
        $this->load->model("System_useracl_model" ,"act");
		$result = $this->act->getActiveByParam();
		
        echo json_encode($result);
	}

	//管理员修改页面
	function update(){
	        $this->load->model("System_useracl_model" ,"act");

			$userId = $this->uri->segment(3);
			$active_Info = $this->act->getActiveById($userId);
			$active_Info->controller = unserialize($active_Info->controller);
			$data['info'] = $active_Info;
			$data['acl_list'] = useracl();
			$data['menu_left'] = $this->menu_left;

			$this->load->view("manage/system_useracledit", $data);
			
	}

	//删除管理员
	function deleteActive(){
        $this->load->model("System_useracl_model" ,"act");
		$userId = $this->input->post("id");

		$result = $this->act->deleteActive($userId);

        echo $result;
	}

	//活动修改执行页面
	function  Act_update(){

			$act_id = $this->input->post("id");
			//ajaxreturn("",$this->input->post(),0);
			$this->load->model("System_useracl_model" ,"act");
			$data1['name'] = $this->input->post("name");
			$data1['controller'] = serialize($this->input->post("model"));
			$data1['intro'] = $this->input->post("intro");
			
			$result = $this->act->updateActive($act_id,$data1);

		   if($result == 1){
				ajaxreturn("","修改成功");
		   }else{
				ajaxreturn("","修改失败",0);
		   }
	}




}