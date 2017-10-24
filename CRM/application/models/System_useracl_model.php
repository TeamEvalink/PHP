<?php
/**
 * 
 * 系统用户模型
 * 物理表job_system_useracl
 * @author tangjw
 *
 */
class System_useracl_model extends CI_Model {

	var $account ;//(账户)    String
	var $password;//(密码)   String
	var $authority;//(权限)  Integer     //最大是10，最小1
	
	//修改密码
	//id -- 系统用户ID
	//oldPwd -- 旧密码
	//newPwd -- 新密码
	//return -- -1表示输入的旧密码错误 , 1表示成功修改
	function updatePwd($id , $oldPwd , $newPwd){
		$query = $this->db->get_where('job_system_useracl', array('id' =>$id , 'password'=>$oldPwd));
		
		if($query->num_rows() == 0){
			return -1 ;

		}else {
			$this->db->set("password" , $newPwd);
			$this->db->where("id" , $id);
			$this->db->update("job_system_useracl");
			return  $this->db->affected_rows();
		}
	}
	/*
	更新管理员登录时间和ip地址
	*/
	function updateUserInfo($id,$last_log_time,$last_log_ip)
	{
		$data = array(
		    'id' => $id,
		    'last_log_time' => $last_log_time,
		    'last_log_ip' => $last_log_ip
		);
		$this->db->update('job_system_useracl', $data, array('id' => $id));
		return  $this->db->affected_rows();
	}
//获取管理员的信息
	function getActiveByParam(){

		$sql = "select count(*) count from job_system_useracl";
		$rs = $this->db->query($sql); 
		$count = $rs->row()->count;  //查询数据总量
		//$per_page = 4;
		$page =  $this->uri->rsegment(3);
		$per_page =  $this->uri->rsegment(5);
		$page_totle = ceil($count/$per_page);

		if(empty($page)||$page<0){
			$page=1;
		}
		
		$offset=($page-1)*$per_page;
		
		$this->db->order_by("id", "asc"); 
		$this->db->limit($per_page,$offset);
		//查询用户表
		$query = $this->db->get('job_system_useracl');
		$res=$query->result();

/*
		//查询用户权限表
		$acl_data = $this->db->get('job_system_useracl');
		$alc_res=$acl_data->result();
		//把权限表结果集的键值变为用户组id
		foreach($alc_res as $key => $v){
			$alc_da[$v->id] = $v;
		}
		//print_r($alc_da);
		//用户组名称赋值
		foreach ($res as $key=>$row)
		{	
			$resdata[$key] = $row;
			$resdata[$key]->last_log_time=date("Y-m-d H:i:s",$row->last_log_time);
		    $resdata[$key]->group=$alc_da[$row->u_group_id]->name;
		}*/
		return $res;
	}

	//删除管理员
	//userId -- 管理员主键Id
	//return -- 修改的行数
	function deleteActive($userId){
		
		$this->db->where("id" ,$userId );
		$this->db->delete("job_system_useracl" );
		return $this->db->affected_rows();

	}
	//修改获取管理员信息
	function getActiveById($userId){
		$query = $this->db->get_where("job_system_useracl" , array("id"=>$userId));
		return $query->row();
	}
	//添加管理员
	//return -- 插入的数据ID
	function addActive($data){

		$this->db->insert("job_system_useracl" , $data);
		return $this->db->insert_id();
		
	}
	
	//修改管理员
	//adId -- 用户主键Id
	//return -- 修改的行数
	function updateActive($adId,$data){
		$this->db->where("id" ,$adId );
		$this->db->update("job_system_useracl" , $data);
		return $this->db->affected_rows();
	}
}