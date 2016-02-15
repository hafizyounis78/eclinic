<?php
class Labmodel extends CI_Model
{
	// Get Constants
	function get_lab()
	{
/*		$myquery = "SELECT   test_code,group_code,lab_test_code,test_desc,result_type_id,test_unit_id,
							 result_status_id,parent_code
					FROM 	 lab_service_tb";
	*/	
		$myquery = "SELECT   category_id,NAME_EN
					FROM 	 category_tb
					WHERE    EXIST=1";
		$res = $this->db->query($myquery);
		return $res->result();
	}
	function get_items($CATEGORYID)
	{
/*		$myquery = "SELECT   test_code,group_code,lab_test_code,test_desc,result_type_id,test_unit_id,
							 result_status_id,parent_code
					FROM 	 lab_service_tb";
	*/	
		$myquery = "SELECT   C_TEST_ITEM_ID,NAME_EN
					FROM 	 items_tb
					WHERE 	CATEGORY_ID = ".$CATEGORYID;
		$res = $this->db->query($myquery);
		return $res->result();
	}
	function get_item_desc($testCode)
	{
/*		$myquery = "SELECT   test_code,group_code,lab_test_code,test_desc,result_type_id,test_unit_id,
							 result_status_id,parent_code
					FROM 	 lab_service_tb";
	*/	
		$myquery = "SELECT   NAME_EN
					FROM 	 category_tb
					WHERE    category_id = ".$testCode;
		$res = $this->db->query($myquery);
		return $res->result();
	}
	function get_lab_order_by_id($labOrderNo)
	{
		
		$myquery = "SELECT   t.test_code,t.test_desc,r.result,r.notes,h.lab_order_no
					FROM 	 lab_service_tb t,lab_order_tb h,lab_order_details_tb d,lab_order_results_tb r
					WHERE    h.lab_order_no=d.lab_order_no
					AND 	 d.Lab_order_details_no=r.Lab_order_details_no
					AND 	 r.item_id=t.test_code
					AND 	 h.lab_order_no=".$labOrderNo;
		$res = $this->db->query($myquery);
		return $res->result();
	}
	
	
	function add_lab_order()
	{
		
		extract($_POST);
		// Insert lab_order_tb
		//if ()
		$data['outpatient_visit_id 	']     	    = $hdnvisitNo;
		$data['order_status_id'] 	= 1;
		date_default_timezone_set('Asia/Gaza');
		$data['order_date'] 		= date("Y-m-d");
		
		
		$this->db->insert('lab_order_tb  ',$data);
		$lab_order_no = $this->db->insert_id();
		$outdata['lab_order_no']   = $lab_order_no;
		
		// Insert lab_order_details_tb
		
		$detailsdata['lab_order_no'] = $lab_order_no;
		$detailsdata['test_id'] = $drpTestName;
		
		$this->db->insert('lab_order_details_tb ',$detailsdata);
		$lab_order_details_no = $this->db->insert_id();
		$outdata['lab_order_details_no']   = $lab_order_details_no;
		// Insert lab_order_results_tb
		
		//***************insert item in lab_order_results_tb
	$rec=$this->get_items($drpTestName);
				
		foreach ($rec as $row)
		{
			
			$resdata['lab_order_details_no'] = $lab_order_details_no;
			$resdata['item_id'] = $row->C_TEST_ITEM_ID;
			
			$this->db->insert('lab_order_results_tb',$resdata);
		}
		
		
		//***************insert item in lab_order_results_tb
		return $outdata;
		
		
	}
function add_test_result()
	{
		
		extract($_POST);
		
		//***************insert item in lab_order_results_tb
				
			
			//$resdata['lab_order_details_no'] = $lab_order_details_no;
			$resdata['result'] = $itemValue;
			$this->db->where('lab_order_details_no',$lab_order_details_no);
			$this->db->where('item_id',$itemid);
			$this->db->update('lab_order_results_tb',$resdata);
		
		
		//***************insert item in lab_order_results_tb
		return $outdata;
		
		
	}
	function get_orderitems($orderDetails_no)
	{

		$myquery = "SELECT   item_id,lab_order_details_no,NAME_EN,lab_order_results_id
					FROM 	 items_tb i,lab_order_results_tb r
					where    i.item_id=r.C_TEST_ITEM_ID
					WHERE 	 lab_order_details = ".$orderDetails_no;
		$res = $this->db->query($myquery);
		return $res->result();
	}

}
?>