<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 联系记录的管理操作
 *
 */

class Sysconnect extends AdminBase {
	function  __construct()
	{
		parent::__construct();

	}
	
	//加载联系记录管理首页
	function clientConnect(){
		$client_id = $this->uri->segment(3);
			
		$sql = "SELECT * FROM job_system_connect WHERE client_id = $client_id ORDER BY input_time DESC";
		$query = $this->db->query($sql);
		$res=$query->result();

		$data['client_id'] = $client_id; 
		$data['list'] = $res;			
		$data['menu_left'] = $this->menu_left;

		$this->load->view('manage/system_connect_client', $data);
	}

	//添加联系记录页面

	function addconnect(){
		$client_id = $this->uri->segment(3);
		$data['client_id'] = $client_id; 
		$data['menu_left'] = $this->menu_left;
		$this->load->view('manage/system_connect_client_add', $data);
	}


	//添加联系记录操作
	function  addActive(){

		$connect_name = $this->input->post("connect_name");
		$connect_tel = $this->input->post("connect_tel");
		$connect_info = $this->input->post("connect_info");
		$connect_date = $this->input->post("connect_date");
		$client_id = $this->input->post("client_id");

		//表单验证
		if (!$connect_name || !$connect_tel || !$connect_info || !$connect_date) {
			ajaxreturn('','必须填写所有数据',0);
		}

		$data = array(
			'client_id' => $client_id,
			'owner_id' => $this->sysInfo['systemUserId'],
			'connect_name' => $connect_name,
			'connect_tel' => $connect_tel,
			'connect_info' => $connect_info,
			'connect_date' => $connect_date,
			'is_connect' => 1,
			'connect_result' => '',
			'input_time' => time(),
			'update_time' => ''
			);
		$this->db->insert('job_system_connect',$data);
		$result = $this->db->insert_id();
		
		if (isset($result)) {
			ajaxreturn("","联系计划添加成功！");
		}else{
			ajaxreturn("","联系计划添加失败！",0);
		}		
	}


	//联系记录修改页面
	function update(){
		$connect_id = $this->uri->segment(3);
		$client_id = $this->uri->segment(4);

		$data['client_id'] = $client_id;
		$data['connect_id'] = $connect_id;
		$data['menu_left'] = $this->menu_left;

		$this->load->view("manage/system_connect_client_update" , $data);
	}

	//修改联系记录操作
	function updateActive(){
		$connect_result = $this->input->post("connect_result");
		$connect_id = $this->input->post("connect_id");
		$data = array(
			'is_connect'	 => 2,
			'connect_result' => $connect_result,
			'update_time' 	 => time()
			);
		$where = array('connect_id' => $connect_id);
		$this->db->update('job_system_connect',$data,$where);
		$result = $this->db->affected_rows();
		
		if ($result == 1) {
			ajaxreturn("","联系记录修改成功！");
		}else{
			ajaxreturn("","联系记录修改失败！",0);
		}
	}

		function indexList(){
		$sysInfo= $this->sysInfo;
		$sql = 'SELECT count(connect_id) as count from job_system_connect where owner_id = ' . $sysInfo['systemUserId'];
		$query = $this->db->query($sql);

		$num = (array)$query->row();

		$count = $num['count'];
	 /****************数据分页******************/
		$per_page=10;
		$page = $this->uri->rsegment(3)==""?1:$this->uri->rsegment(3);//当前页
		
		$page_totle = ceil($count/$per_page);
		$this->load->library('pagination');

		$config['base_url'] = base_url().$this->uri->rsegment(1)."/".$this->uri->rsegment(2);
		$config['total_rows'] = $count;//总条数
		$config['per_page'] = $per_page;//每页显示条数
		$config['uri_segment'] = 3;
		$config['num_links'] = 2;

		$config['first_link'] = '首页'; // 第一页显示   
		$config['last_link'] = '末页'; // 最后一页显示   
		$config['next_link'] = '下一页'; // 下一页显示   
		$config['prev_link'] = '上一页'; // 上一页显示
		$config['use_page_numbers'] = TRUE;//true分页链接里的数字为第几页，false为起始数据

		$config['num_tag_open'] = '&nbsp;';//数字起始标签


		$config['num_tag_close'] = '&nbsp;';//数字结束标签

		$config['page_query_string'] = false;
		$config['reuse_query_string'] = true;
		$this->pagination->initialize($config);

		$links = $this->pagination->create_links();

		$offset=($page-1)*$per_page;
			
		$this->db->order_by("connect_id", "desc"); 
		$limit = "LIMIT ". $offset.",".$per_page;


		$sql = "SELECT * FROM job_system_connect WHERE owner_id = " . $sysInfo['systemUserId'] . "  ORDER BY connect_id DESC  ".$limit ;
		$query = $this->db->query($sql);
		$res=$query->result();	
		

		$data['page'] = $page;
		$data['count'] = $count;
		$data['per_page'] = $per_page;
		$data['page_totle'] = $page_totle;

		$data['links']=$links;
		$data['list']=$res;
		
				
		$data['menu_left'] = $this->menu_left;

		$this->load->view('manage/system_connect_list', $data);
	}

}