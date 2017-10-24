<?php
/**
 * 
 * 系统设置模型
 * @author shiyi
 *
 */
class System_config_model extends CI_Model {
	
	
	function getdata(){
		$sql="select * from job_sysconfig";
		$query = $this->db->query($sql);
		return $query->result();
	}
	function getcodedata(){
		$sql="select * from job_sysconfig";
		$query = $this->db->query($sql);
		$res=$query->result();
		$array="";
		foreach ($res as $key => $value) {
			$array[$value->code]=$value->value;
		}
		return $array;
	}
	
	//根据ID获取限制值
	//tangjw
	function getLimitByCode($code){
		$query = $this->db->get_where('job_sysconfig', array('code' => $code));
    	$row = $query->row();
    	return $row;
	}
	
}