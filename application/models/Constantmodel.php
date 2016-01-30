<?php
class Constantmodel extends CI_Model
{
	// Get Constants
	function get_constant()
	{
		$this->db->from('constant_tb');
		$this->db->order_by("constant_name", "ASC");
		
		$query = $this->db->get();
		
		return $query->result();
	}
	
	// Get Sub Constant By Constant
	function get_sub_constant($constant_id)
	{
		$this->db->from('sub_constant_tb');
		$this->db->where('constant_id',$constant_id);
		$this->db->order_by("sub_constant_name", "ASC");
		
		$query = $this->db->get();
		
		return $query->result();
	}
	
	// Insert Constant
	function constant_insart()
	{
		extract($_POST);
		date_default_timezone_set('Asia/Gaza');
		$sdata = $this->session->userdata('logged_in');
		
		$data['constant_name'] = $txtConstantName;
		$data['created_on']  = date("Y-m-d H:i:s");
		$data['created_by']  = $sdata['userid'];
		
		$this->db->insert('constant_tb',$data);
	}
	
	// Insert Sub Constant
	function sub_constant_insart()
	{
		extract($_POST);
		date_default_timezone_set('Asia/Gaza');
		$sdata = $this->session->userdata('logged_in');
		
		$data['constant_id'] = $hdnConstantid;
		$data['sub_constant_name'] = $txtSubConstantName;
		$data['created_on']  = date("Y-m-d H:i:s");
		$data['created_by']  = $sdata['userid'];
		
		$this->db->insert('sub_constant_tb',$data);
	}
	
	// Update Constant
	function constant_update()
	{
		extract($_POST);
		$data['constant_id'] = $hdnConstantid;
		$data['constant_name'] = $txtConstantName;
		
		$this->db->where('constant_id',$hdnConstantid);
		$this->db->update('constant_tb',$data);
	}
	
	// Update Sub Constant
	function sub_constant_update()
	{
		extract($_POST);
		$data['sub_constant_id'] = $hdnSubConstid;
		$data['sub_constant_name'] = $txtSubConstantName;
		
		$this->db->where('sub_constant_id',$hdnSubConstid);
		$this->db->update('sub_constant_tb',$data);
	}
//************* get parent*********//
function get_region_list($governorateCode)
	{	
		$this->db->where('parent_id',$governorateCode);
		$query = $this->db->get('sub_constant_tb ');
		return $query->result();
		
	}
function get_fulladress_list($regionCode)
	{	
		$this->db->where('parent_id',$regionCode);
		$query = $this->db->get('sub_constant_tb ');
		return $query->result();
		
	}

//************end get parent********//

	function get_constant_for_sms()
	{
		$myquery = "SELECT constant_id, constant_name
					  FROM constant_tb 
					 WHERE constant_id IN (22,23,24,26,7,54,30,32,33,41,56,44,45,46,47,49,48)";
		
		$res = $this->db->query($myquery);
		return $res->result();
	}
	function get_all_city($constant_id)
	{
		extract($_POST);
		
		$myquery = "SELECT sub_constant_id, constant_id, sub_constant_name, parent_id
					  FROM sub_constant_tb 
					 WHERE constant_id IN (".$constant_id.")";
		
		$res = $this->db->query($myquery);
		return $res->result();
	}
}
?>