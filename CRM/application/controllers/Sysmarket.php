<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 渠道的管理操作
 *
 */

class Sysmarket extends AdminBase {
	function  __construct()
	{
		parent::__construct();

	}
	
	//加载渠道管理首页
	function index(){
		$query = $this->db->query("select count(market_id) as count from job_system_market");

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
			
		$this->db->order_by("market_id", "desc"); 
		$limit = "LIMIT ". $offset.",".$per_page;

		$sql = "SELECT market_id,market_name,insert_time FROM job_system_market ORDER BY market_id DESC  ".$limit ;
		$query = $this->db->query($sql);
		$res=$query->result();

		$data['page'] = $page;
		$data['count'] = $count;
		$data['per_page'] = $per_page;
		$data['page_totle'] = $page_totle;

		$data['links']=$links;
		$data['list']=$res;
		$data['sysInfo'] = $this->sysInfo;
		
		$data['menu_left'] = $this->menu_left;

		$this->load->view('manage/system_market', $data);
	}

	//添加渠道页面

	function add(){
		$data['menu_left'] = $this->menu_left;
		$this->load->view('manage/system_marketadd', $data);
	}


	//添加渠道操作
	function  addActive(){

		$name = $this->input->post("name");

		if (!$name) {
			ajaxreturn('','渠道名称不能为空',0);
		}
		$data = array(
			'name' => $name,
			'insert_time' => time()
			);
		$this->db->insert('job_system_market',$data);
		$result = $this->db->insert_id();
		
		if (isset($result)) {
			ajaxreturn("","渠道添加成功！");
		}else{
			ajaxreturn("","渠道添加失败！",0);
		}			
	}


	//渠道修改页面
	function update(){
		$id = $this->uri->segment(3);
		
		$result = $this->db->select('market_name')->get_where('job_system_market', array('market_id'=>$id))->row();

		$data['market_name'] = $result->market_name;
		$data['id'] = $id;
		$data['menu_left'] = $this->menu_left;

		$this->load->view("manage/system_marketupdate" , $data);
	}

	//修改渠道操作
	function updatemarket(){
		$name = $this->input->post("name");
		$id = $this->input->post("market_id");
		$data = array(
			'name' => $name,
			'insert_time' => time()
			);
		$where = array('market_id' => $id);
		$this->db->update('job_system_market',$data,$where);
		$result = $this->db->affected_rows();
		
		if ($result == 1) {
			ajaxreturn("","渠道修改成功！");
		}else{
			ajaxreturn("","渠道修改失败！",0);
		}
	}

	//删除渠道操作
	function delete(){
        
		$id = $this->input->post("id");
		$this->db->where('id',$id)->delete('job_system_market');
		$result = $this->db->affected_rows();
		
		if ($result == 1) {
			ajaxreturn("","渠道删除成功！");
		}else{
			ajaxreturn("","渠道删除失败！",0);
		}

	}

}