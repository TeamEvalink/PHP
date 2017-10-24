<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 合同的管理操作
 *
 */

class Sysconstract extends AdminBase {
	function  __construct()
	{
		parent::__construct();

	}

	function index(){
		$sysInfo= $this->sysInfo;
		$sql = 'SELECT count(constract_id) as count from job_system_constract where owner_id = ' . $sysInfo['systemUserId'];
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
			
		$this->db->order_by("constract_id", "desc"); 
		$limit = "LIMIT ". $offset.",".$per_page;


		$sql = "SELECT * FROM job_system_constract WHERE owner_id = " . $sysInfo['systemUserId'] . "  ORDER BY constract_id DESC  ".$limit ;
		$query = $this->db->query($sql);
		$res=$query->result();	
		

		$data['page'] = $page;
		$data['count'] = $count;
		$data['per_page'] = $per_page;
		$data['page_totle'] = $page_totle;

		$data['links']=$links;
		$data['list']=$res;
		
				
		$data['menu_left'] = $this->menu_left;

		$this->load->view('manage/system_constract_client_list', $data);
	}

	
	//加载合同管理首页
	function clientConstract(){
		$client_id = $this->uri->segment(3);
			
		$sql = "SELECT * FROM job_system_constract WHERE client_id = $client_id ORDER BY input_time DESC";
		$query = $this->db->query($sql);
		$res=$query->result();

		$data['client_id'] = $client_id; 
		$data['list'] = $res;			
		$data['menu_left'] = $this->menu_left;

		$this->load->view('manage/system_constract_client', $data);
	}

	//添加合同页面

	function addConstract(){

		$client_id = $this->uri->segment(3);
		$data['client_id'] = $client_id; 
		$data['menu_left'] = $this->menu_left;
		$this->load->view('manage/system_constract_client_add', $data);
	}


	//添加合同操作
	function  addActive(){
		
		$contract_no = $this->input->post("contract_no");
		$client_id = $this->input->post("client_id");
		$contract_money = $this->input->post("contract_money");
		$sign_date = $this->input->post("sign_date");
		$contract_limit = $this->input->post("contract_limit");
		$contract_status = $this->input->post("contract_status");
		$contract_condition = $this->input->post("contract_condition");
		$contract_type = $this->input->post("contract_type");
		$class_num = $this->input->post("class_num");

		

		//表单验证
		if (!$contract_no || !$contract_money || !$sign_date || !$contract_limit || !$class_num) {
			ajaxreturn('','必须填写所有数据',0);
		}

		//查询客户编号
		$sql = "SELECT * FROM job_system_client WHERE client_id = ". $client_id;
		$query = $this->db->query($sql);
		$res=$query->row();

		//查询当前用户姓名owner_name
		$nameSql = "SELECT * FROM job_system_user WHERE id = ". $this->sysInfo['systemUserId'];
		$nameQuery = $this->db->query($nameSql);
		$nameRes=$nameQuery->row();

		$data = array(
			'contract_no' => $contract_no,	
			'client_no' => $res->client_no,		
			'client_id' => $client_id,		
			'owner_id' => $this->sysInfo['systemUserId'],
			'owner_name' => $nameRes->user_name,
			'contract_money' => $contract_money,
			'sign_date' => $sign_date,
			'contract_limit' => $contract_limit,
			'contract_status' => $contract_status,
			'contract_condition' => $contract_condition,
			'contract_type' => $contract_type,
			'class_num' => $class_num,
			'input_time' => time(),
			'update_time' => ''
		);

		$this->db->insert('job_system_constract',$data);
		$result = $this->db->insert_id();
		
		if (isset($result)) {
			//合同添加成功，潛在客戶将变成正式客户
			$data = array(
				'is_constract' => 2
			);

			$where = array('client_id' => $client_id);
			$this->db->update('job_system_client',$data,$where);
			$updateresult = $this->db->affected_rows();

			if (!isset($updateresult)) {
				ajaxreturn("","合同添加成功，但转化为正式客户失败，请联系管理员",0);
			}				

			ajaxreturn("","合同添加成功！");
		}else{
			ajaxreturn("","合同添加失败！",0);
		}		
	}


	//合同修改页面
	function update(){
		$constract_id = $this->uri->segment(3);
		
		//查询合同信息
		$sql = "SELECT * FROM job_system_constract WHERE constract_id = ". $constract_id;
		$query = $this->db->query($sql);
		$res=$query->row();

		$data['list'] = $res;
		$data['menu_left'] = $this->menu_left;

		$this->load->view("manage/system_constract_client_update" , $data);
	}

	//修改合同操作
	function updateActive(){

		$constract_id = $this->input->post("constract_id");
		$contract_no = $this->input->post("contract_no");		
		$contract_money = $this->input->post("contract_money");
		$sign_date = $this->input->post("sign_date");
		$contract_limit = $this->input->post("contract_limit");
		$contract_status = $this->input->post("contract_status");
		$contract_condition = $this->input->post("contract_condition");
		$contract_type = $this->input->post("contract_type");
		$class_num = $this->input->post("class_num");

		

		//表单验证
		if (!$contract_no || !$contract_money || !$sign_date || !$contract_limit || !$class_num) {
			ajaxreturn('','必须填写所有数据',0);
		}

		$data = array(
			'contract_no' => $contract_no,	
			'contract_money' => $contract_money,
			'sign_date' => $sign_date,
			'contract_limit' => $contract_limit,
			'contract_status' => $contract_status,
			'contract_condition' => $contract_condition,
			'contract_type' => $contract_type,
			'class_num' => $class_num,
			'update_time' => time()
		);

		$where = array('constract_id' => $constract_id);
		$this->db->update('job_system_constract',$data,$where);
		$result = $this->db->affected_rows();
		
		if (isset($result)) {
			ajaxreturn("","合同修改成功！");
		}else{
			ajaxreturn("","合同修改失败！",0);
		}
		
	}

}