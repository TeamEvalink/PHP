<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 潜在客户的管理操作
 *
 */

class Syschild extends AdminBase {
	function  __construct()
	{
		parent::__construct();

	}
	

	//小朋友页面
	function child(){
		$client_id = $this->uri->segment(3);

		//查询潜在用户信息
		$sql = "SELECT * FROM job_system_client WHERE client_id = ". $client_id;
		$query = $this->db->query($sql);
		$res=$query->row();
		$data['customer_type']  = $res->customer_type;
		
		//查询小朋友信息
		$childSql = 'select * from job_system_child where client_id ='. $client_id;
		$childArr = $this->db->query($childSql)->result();
		$data['childArr'] = $childArr;
		$data['client_id'] = $client_id;

		$data['menu_left'] = $this->menu_left;
		$this->load->view('manage/system_child', $data);
	}

	//新增小朋友页面
	function childAdd(){
		$client_id = $this->uri->segment(3);

		$data['client_id'] = $client_id;
		$data['menu_left'] = $this->menu_left;
		$this->load->view('manage/system_childadd', $data);
	}

	function childAddActive(){		
		$client_id = $this->input->post('client_id');
		$child_name = $this->input->post('child_name');
		$shot_name = $this->input->post('shot_name');
		$child_sex = $this->input->post('child_sex');
		$nickname = $this->input->post('nickname');
		$brithday = $this->input->post('brithday');
		$child_age = $this->input->post('child_age');
		$is_ban = $this->input->post('is_ban');

		if (!$child_name || !$shot_name) {
			ajaxreturn("","请完善小朋友信息",0);
		}

		//查询潜在用户信息
		$sql = "SELECT * FROM job_system_client WHERE client_id = ". $client_id;
		$query = $this->db->query($sql);
		$res=$query->row();

		$data = array(
			'owner_id' => $this->sysInfo['systemUserId'],
			'client_no' => $res->client_no,
			'client_id' => $client_id,
			'child_name' => $child_name,
			'shot_name' => $shot_name,
			'child_sex' => $child_sex,
			'nickname' => $nickname,
			'brithday' => $brithday,
			'child_age' => $child_age,
			'is_ban' => $is_ban
			);
		$this->db->insert('job_system_child',$data);
		$result = $this->db->insert_id();
		
		if (isset($result)) {
			ajaxreturn("","小朋友添加成功！");
		}else{
			ajaxreturn("","小朋友添加失败！",0);
		}
	}


	//删除小朋友
	function delChild(){        
		$child_id = $this->input->post("id");
		$this->db->where('child_id',$child_id)->delete('job_system_child');
		$result = $this->db->affected_rows();
		
		if ($result == 1) {
			ajaxreturn("","潜在小朋友删除成功！");
		}else{
			ajaxreturn("","潜在小朋友删除失败！",0);
		}

	}

	//更新小朋友信息页面
	function updateChild(){
		$child_id = $this->uri->segment(3);

		//查找潜在客户信息
		$sql = "SELECT * FROM job_system_child WHERE child_id = ". $child_id;
		$query = $this->db->query($sql);
		$res=$query->row();		

		$data['list'] = $res;
		$data['menu_left'] = $this->menu_left;

		$this->load->view("manage/system_childupdate" , $data);
	}

	//更新小朋友信息操作
	function childUpdateActive(){

		$child_id = $this->input->post('child_id');
		$child_name = $this->input->post('child_name');
		$shot_name = $this->input->post('shot_name');
		$child_sex = $this->input->post('child_sex');
		$nickname = $this->input->post('nickname');
		$brithday = $this->input->post('brithday');
		$child_age = $this->input->post('child_age');
		$is_ban = $this->input->post('is_ban');

		//表单验证
		if (!$child_name) {
			ajaxreturn('','姓名不能为空',0);
		}

		if (!$child_id) {
			ajaxreturn('','内部错误，请联系技术人员',0);
		}

		$data = array(
			'child_name' => $child_name,
			'shot_name' => $shot_name,
			'child_sex' => $child_sex,
			'nickname' => $nickname,
			'brithday' => $brithday,
			'child_age' => $child_age,
			'is_ban' => $is_ban
			);
		
		$where = array('child_id' => $child_id);
		$this->db->update('job_system_child',$data,$where);
		$result = $this->db->affected_rows();
		
		if (isset($result)) {
			ajaxreturn("","小朋友更新成功！");
		}else{
			ajaxreturn("","小朋友更新失败！",0);
		}
	}


	function index(){
		$sysInfo= $this->sysInfo;
		$sql = 'SELECT count(child_id) as count from job_system_child where owner_id = ' . $sysInfo['systemUserId'];
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
			
		$this->db->order_by("child_id", "desc"); 
		$limit = "LIMIT ". $offset.",".$per_page;


		$sql = "SELECT * FROM job_system_child WHERE owner_id = " . $sysInfo['systemUserId'] . "  ORDER BY child_id DESC  ".$limit ;
		$query = $this->db->query($sql);
		$res=$query->result();	
		
		foreach ($res as $key => $value) {
			$sql = "SELECT * FROM job_system_client WHERE client_id = ". $value->client_id;
			$query = $this->db->query($sql);
			$typeRes=$query->row();
			$res[$key]->customer_type  = $typeRes->customer_type;
		}


		$data['page'] = $page;
		$data['count'] = $count;
		$data['per_page'] = $per_page;
		$data['page_totle'] = $page_totle;

		$data['links']=$links;
		$data['list']=$res;
		
				
		$data['menu_left'] = $this->menu_left;

		$this->load->view('manage/system_child_list', $data);
	}

}