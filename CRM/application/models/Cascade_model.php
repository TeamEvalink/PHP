<?php
/**
 * 
 * 各种联动类型的内容，如岗位联动分类，城市联动分类，月薪分类下拉菜单等
 * 总共只有三级内容
 * 相关数据库表job_cascade_title ，job_cascade_content
 * @author tangjw
 *
 */
class Cascade_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    
    
    
    //只添加联动种类，不添加种类一级内容,返回种类ID，
    //titleArr --种类标题数组
    //return --插入的行数
    function addCcdType($titleArr){
        $dataArr = array();
    	foreach ($titleArr as $title){
    		 $data = array("name"=>$title);
    		 array_push($dataArr, $data);
    	}
    	 $this->db->insert_batch('job_cascade_title', $dataArr);
        return $this->db->affected_rows();
    }
   
    
    //批量添加子级联动内容
    //typeId -- 类型ID
    //topId  -- 上级内容ID
    //content -- 子级内容
    //return -- 插入的子级数量
    function  addChildContent($typeId , $topId , $contentArr){
    	 //先获取上级内容的级别数，加上1才是子级内容的级别数
    	 $query = $this->db->get_where("job_cascade_content" , array("id"=>$topId));
    	 $row = $query->row();
    	 $level = $row->level + 1 ;
    	 
    	 //再批量添加子级内容
    	$dataArr = array();
    	foreach ($contentArr as $content){
    		 $data = array("tid"=>$typeId ,
		               "topid"=>$topId ,
		               "content" =>$content ,
		               "level"=>$level);
    		 array_push($dataArr, $data);
    	}
    	$this->db->insert_batch('job_cascade_content', $dataArr);
        return $this->db->affected_rows();

    }
    
    
    //同时添加联动种类和一级内容
    //title--种类标题
    //contentArr -- 一级内容数组  
    //return -- 插入的一级内容数量
    function addCcdTypeAndOneLevCont($title , $contentArr){
    	
    	$this->db->set("name",$title);
    	$this->db->insert("job_cascade_title");
    	$typeId = $this->db->insert_id();
    	
    	//循环插入一级内容
    	$dataArr = array();
    	foreach ($contentArr as $content){
    		$data = array("tid"=>$typeId,
    		              "topid"=>0,
    		             "content"=>$content ,
    		             "level"=>1);
    		 array_push($dataArr, $data);
    	}
    	 $this->db->insert_batch('job_cascade_content', $dataArr);
    	 return $this->db->affected_rows();
    	
    }
    
    
    //添加一级内容和子级内容
    //typeID --联动类型ID
    //oneLevTile -- 一级内容
    //childContArr -- 一级内容对应的子级内容数组
    //return -- 一级内容ID和对应的子级内容数量
    function addOneLevAndCont($typeId , $oneLevTitle , $childContArr){
    	//先插入一级内容
    	$oneLevData = array("tid"=>$typeId,
    		              "topid"=>0,
    		             "content"=>$oneLevTitle,
    	                  "level"=>1);
    	 $this->db->insert('job_cascade_content', $oneLevData);
    	 $oneLevId = $this->db->insert_id();
    	
    	 //再插入对应的二级内容
    	$dataArr = array();
    	foreach ($childContArr as $content){
    		$data = array("tid"=>$typeId,
    		              "topid"=>$oneLevId,
    		             "content"=>$content,
    	                  "level"=>2);

    		 array_push($dataArr, $data);
    	}
    	 $this->db->insert_batch('job_cascade_content', $dataArr);
    	 $result = $this->db->affected_rows();
    	 return array("oneLevId"=>$oneLevId , "childNum"=>$result);
    }
    
    
    //删除联动类型，包括联动类型及其内容
    //typeId -- 联动类型ID
    //return -- 删除的类型数量和内容数量
    function deleteCcd($typeId){
    	$this->db->delete('job_cascade_title', array('id' => $typeId));
    	$typeNum = $this->db->affected_rows();
    	$this->db->delete('job_cascade_content', array('tid' => $typeId));
    	$contentNum = $this->db->affected_rows();
    	return array("typeNum"=>$typeNum , "contentNum"=>$contentNum);
    }
    
    
    //删除联动内容，包括其子级的内容，默认只有三级
    //contentId -- 联动内容ID   
    //return -- 删除的一级
    function deleteContent($contentId){
    	//先删除其子级内容
    	$this->db->delete('job_cascade_content', array('topid' => $contentId));
    	$childContNum = $this->db->affected_rows();
    	
    	//再删除本条记录
    	$this->db->delete('job_cascade_content', array('id' => $contentId));
    	$oneLevNum = $this->db->affected_rows();
    	return array("oneLevNum"=>$oneLevNum , "childContNum"=>$childContNum);
    }
    
    
    //获取所有的联动类型
    //return -- 所有联动类型的对象数组
    function getCcdTypes(){
    	 $query = $this->db->get('job_cascade_title');
    	 return $query->result();
    }
    
    
    //根据ID获取某一项联动类别
    //ccdId -- 联动类别ID
    //return -- 联动类别对象
    function  getCcdTypeById($ccdId){
    	 $query = $this->db->get_where('job_cascade_title',array('id' => $ccdId ));
    	 return $query->row();;
    }
    
    
    //获取某一项联动的子级内容
    // typeId -- 联动类型ID
    // topId -- 上级栏目ID ， 0表示一级栏目
    //return  -- 联动内容的对象数组
    function getCcdContById($typeId , $topId){
    	$this->db->order_by("order_num" , "asc");
    	$query = $this->db->get_where('job_cascade_content', array('tid' => $typeId , "topid"=>$topId));
    	$result  = $query->result();
    	return $result;
    }
    
    //获取某一项联动的一级，二级，三级内容,用于填充下拉框
    //typeId -- 联动类别ID
    //return -- 一级内容对象数组
    function getCcdConts($typeId){
    	//先获取一级内容数组
    	$this->db->order_by("order_num" , "asc");
    	$query = $this->db->get_where('job_cascade_content', array('tid' => $typeId , "topid"=>0));
    	$oneLevArr  = $query->result();
    	
    	//再获取二级类容
    	foreach ($oneLevArr as &$oneLev){
    		    $this->db->order_by("order_num" , "asc");
    	        $query1 = $this->db->get_where('job_cascade_content', array('tid' => $typeId , "topid"=>$oneLev->id));
    	        $twoLevArr  = $query1->result();
    	        //将获得的二级内容动态付给一级内容对象
    	        $oneLev->childContArr = $twoLevArr;
    	        
    	        //查询获取第三级内容
    	        foreach($twoLevArr as &$twoLev){
    	        	$this->db->order_by("order_num" , "asc");
	    	        $query2 = $this->db->get_where('job_cascade_content', array('tid' => $typeId , "topid"=>$twoLev->id));
	    	        $threeLevArr  = $query2->result();
	    	        $twoLev -> childContArr = $threeLevArr;
    	        }

    	}   	
    	return $oneLevArr;
    }
    

    //修改联动类型名称
    //id -- 联动类型ID
    //typeName -- 类型名称
    //return -- 修改的行数
    function updateCcdTypeName($id , $typeName){
    	$this->db->set("name" , $typeName);
    	$this->db->where("id",$id);
    	$this->db->update("job_cascade_title");
    	return $this->db->affected_rows();
    	
    }
    
    //更新联动子项内容
    //contentId -- 子项内容ID
    //content -- 子项内容
    //orderNum -- 排序号
    //return -- 修改的行数
    function updateCcdCont($contentId , $content , $orderNum){
    	$this->db->set("content" , $content);
    	$this->db->set("order_num" , $orderNum);
    	$this->db->where("id",$contentId);
    	$this->db->update("job_cascade_content");
    	return $this->db->affected_rows();
    }
    
    //根据ID获取级联内容
    function getContentById($id){
    	$query = $this->db->get_where('job_cascade_content', array('id' => $id));
		$row = $query->row();
		return  $row ;
    }
    
    //获取所有的联动内容
    function getALLCcd(){
    	$sql = "select id , content from job_cascade_content";
    	$query = $this->db->query($sql);
		return $query->result();
    }
}