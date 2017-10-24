<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 潜在客户的管理操作
 *
 */

class Sysclient extends AdminBase {
	function  __construct()
	{
		parent::__construct();

	}
	
	//加载潜在客户管理首页
	function index(){
		$sysInfo= $this->sysInfo;
		$sql = 'SELECT count(client_id) as count from job_system_client where is_constract = 1 AND owner_id = ' . $sysInfo['systemUserId'];
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
			
		$this->db->order_by("client_id", "desc"); 
		$limit = "LIMIT ". $offset.",".$per_page;


		$sql = "SELECT * FROM job_system_client WHERE is_constract = 1 AND owner_id = " . $sysInfo['systemUserId'] . "  ORDER BY client_id DESC  ".$limit ;
		$query = $this->db->query($sql);
		$res=$query->result();
		
		foreach ($res as $key => $value) {
			//查找销售姓名
			$res[$key]->seller_name = '';
			if (isset($value->seller_id)) {
				$sql = 'SELECT user_name from job_system_user WHERE id = ' . $value->seller_id;
				$seller = $this->db->query($sql)->row();
				
				$res[$key]->seller_name = $seller->user_name;
			}

			//查找小朋友姓名
			$childSql = 'SELECT child_name FROM job_system_child WHERE client_id = ' . $value->client_id;
			$childName = $this->db->query($childSql)->row();
			$res[$key]->child_name = isset($childName->child_name) ? $childName->child_name : '';

			//查找渠道姓名
			$markerSql = 'SELECT market_name FROM job_system_market WHERE market_id = ' . $value->market_id;
			$marketName = $this->db->query($markerSql)->row();
			$res[$key]->market_name = isset($marketName->market_name) ? $marketName->market_name : '';
			
		}

		$data['page'] = $page;
		$data['count'] = $count;
		$data['per_page'] = $per_page;
		$data['page_totle'] = $page_totle;

		$data['links']=$links;
		$data['list']=$res;
		
				
		$data['menu_left'] = $this->menu_left;

		$this->load->view('manage/system_client', $data);
	}

	function indexForTrue(){
		$sysInfo= $this->sysInfo;
		$sql = 'SELECT count(client_id) as count from job_system_client where is_constract = 2 AND owner_id = ' . $sysInfo['systemUserId'];
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
			
		$this->db->order_by("client_id", "desc"); 
		$limit = "LIMIT ". $offset.",".$per_page;


		$sql = "SELECT * FROM job_system_client WHERE is_constract = 2 AND owner_id = " . $sysInfo['systemUserId'] . "  ORDER BY client_id DESC  ".$limit ;
		$query = $this->db->query($sql);
		$res=$query->result();
		
		foreach ($res as $key => $value) {
			//查找销售姓名
			$res[$key]->seller_name = '';
			if (isset($value->seller_id)) {
				$sql = 'SELECT user_name from job_system_user WHERE id = ' . $value->seller_id;
				$seller = $this->db->query($sql)->row();
				
				$res[$key]->seller_name = $seller->user_name;
			}

			//查找小朋友姓名
			$childSql = 'SELECT child_name FROM job_system_child WHERE client_id = ' . $value->client_id;
			$childName = $this->db->query($childSql)->row();
			$res[$key]->child_name = isset($childName->child_name) ? $childName->child_name : '';

			//查找渠道姓名
			$markerSql = 'SELECT market_name FROM job_system_market WHERE market_id = ' . $value->market_id;
			$marketName = $this->db->query($markerSql)->row();
			$res[$key]->market_name = isset($marketName->market_name) ? $marketName->market_name : '';
			
		}

		$data['page'] = $page;
		$data['count'] = $count;
		$data['per_page'] = $per_page;
		$data['page_totle'] = $page_totle;

		$data['links']=$links;
		$data['list']=$res;
		
				
		$data['menu_left'] = $this->menu_left;

		$this->load->view('manage/system_client_true', $data);
	}

	//添加潜在客户页面

	function addClient(){
		//查询渠道信息
		$marketNameSql = 'select * from job_system_market where is_del = 0';
		$markerNameArr = $this->db->query($marketNameSql)->result();
		$data['mark_name'] = $markerNameArr;

		$data['menu_left'] = $this->menu_left;
		$this->load->view('manage/system_clientadd', $data);
	}


	//添加潜在客户操作
	function  addActive(){
		$customer_from = $this->input->post("customer_from");
		$market = $this->input->post("market");
		$customer_from = $this->input->post("customer_from");
		$customer_ratio = $this->input->post("customer_ratio");
		$customer_type = $this->input->post("customer_type");
		$father_name = $this->input->post("father_name");
		$father_tel = $this->input->post("father_tel");
		$mather_name = $this->input->post("mather_name");
		$mather_tel = $this->input->post("mather_tel");
		$input_time = $this->input->post("input_time");

		//表单验证
		if (!$father_tel && !$mather_tel) {
			ajaxreturn('','父亲手机号和母亲手机号不能都为空',0);
		}

		if (!$father_name && !$mather_name) {
			ajaxreturn('','父亲姓名和母亲姓名不能都为空',0);
		}

		if (!$input_time) {
			ajaxreturn('','请输入创建时间',0);
		}
		$data = array(
			'client_no' => time(),
			'writer_id' => $this->sysInfo['systemUserId'],
			'owner_id' => $this->sysInfo['systemUserId'],
			'market_id' => $market,
			'customer_from' => $customer_from,
			'customer_ratio' => $customer_ratio,
			'customer_type' => $customer_type,
			'father_name' => $father_name,
			'father_tel' => $father_tel,
			'mather_name' => $mather_name,
			'mather_tel' => $mather_tel,
			'input_time' => $input_time
			);
		$this->db->insert('job_system_client',$data);
		$result = $this->db->insert_id();
		
		if (isset($result)) {
			ajaxreturn("","潜在客户添加成功！");
		}else{
			ajaxreturn("","潜在客户添加失败！",0);
		}			
	}


	//潜在客户修改页面
	function update(){
		$client_id = $this->uri->segment(3);
		//查找潜在客户信息
		$sql = "SELECT * FROM job_system_client WHERE client_id = ". $client_id;
		$query = $this->db->query($sql);
		$res=$query->row();

		//查询渠道信息
		$marketNameSql = 'select * from job_system_market where is_del = 0';
		$markerNameArr = $this->db->query($marketNameSql)->result();
		$data['mark_name'] = $markerNameArr;

		$data['list'] = $res;
		$data['menu_left'] = $this->menu_left;

		$this->load->view("manage/system_clientupdate" , $data);
	}

	//修改潜在客户操作
	function updateclient(){
		
		$client_id = $this->input->post("client_id");

		$customer_from = $this->input->post("customer_from");
		$market = $this->input->post("market");
		$customer_from = $this->input->post("customer_from");
		$customer_ratio = $this->input->post("customer_ratio");
		$customer_type = $this->input->post("customer_type");
		$father_name = $this->input->post("father_name");
		$father_tel = $this->input->post("father_tel");
		$mather_name = $this->input->post("mather_name");
		$mather_tel = $this->input->post("mather_tel");
		$input_time = $this->input->post("input_time");

		//表单验证
		if (!$father_tel && !$mather_tel) {
			ajaxreturn('','父亲手机号和母亲手机号不能都为空',0);
		}

		if (!$father_name && !$mather_name) {
			ajaxreturn('','父亲姓名和母亲姓名不能都为空',0);
		}

		if (!$input_time) {
			ajaxreturn('','请输入创建时间',0);
		}
		$data = array(
			'client_no' => time(),
			'owner_id' => $this->sysInfo['systemUserId'],
			'market_id' => $market,
			'customer_from' => $customer_from,
			'customer_ratio' => $customer_ratio,
			'customer_type' => $customer_type,
			'father_name' => $father_name,
			'father_tel' => $father_tel,
			'mather_name' => $mather_name,
			'mather_tel' => $mather_tel,
			'input_time' => $input_time
			);
		// ajaxreturn('',json_encode($data),0);
		$where = array('client_id' => $client_id);
		$this->db->update('job_system_client',$data,$where);
		$result = $this->db->affected_rows();
		
		if ($result == 1) {
			ajaxreturn("","潜在客户修改成功！");
		}else{
			ajaxreturn("","潜在客户修改失败！",0);
		}
	}

	//删除潜在客户操作
	function delete(){
        
		$id = $this->input->post("id");
		$this->db->where('client_id',$id)->delete('job_system_client');
		$result = $this->db->affected_rows();
		
		if ($result == 1) {
			ajaxreturn("","潜在客户删除成功！");
		}else{
			ajaxreturn("","潜在客户删除失败！",0);
		}

	}
	//分配客户页面
	function share(){
		$client_id = $this->uri->segment(3);
	
		//查找所有销售
		$sellerSql = 'select id,user_name from job_system_user where u_group_id = 3';
		$sellerNameArr = $this->db->query($sellerSql)->result();
		$data['seller_arr'] = $sellerNameArr;
		$data['client_id'] = $client_id;
		$data['menu_left'] = $this->menu_left;

		$this->load->view("manage/system_clientshare" , $data);
	}

	//分配客户操作
	function shareActive(){
		$client_id = $this->input->post("client_id");
		$user_id = $this->input->post("user_id");

		if (!$user_id) {
			ajaxreturn('','请选择销售',0);
		}

		$data = array(
			'owner_id' => $user_id,
			);
		$where = array('client_id' => $client_id);
		$this->db->update('job_system_client',$data,$where);
		$result = $this->db->affected_rows();
		if ($result == 1) {
			$this->db->update('job_system_child',$data,$where);
			$this->db->update('job_system_constract',$data,$where);
			$this->db->update('job_system_connect',$data,$where);
		}
		
		if ($result == 1) {
			ajaxreturn("","潜在客户分配成功！");
		}else{
			ajaxreturn("","潜在客户分配失败！",0);
		}		
	}

	

}