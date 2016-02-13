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
		$myquery = "SELECT   test_code,test_desc
					FROM 	 lab_service_tb";
		$res = $this->db->query($myquery);
		return $res->result();
	}
	function add_lab_order()
	{
		
		extract($_POST);
		// Insert lab_order_tb
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

		// Insert lab_order_results_tb
		
		$resdata['lab_order_details_no'] = $lab_order_details_no;
		$resdata['item_id'] = $drpTestName;
		
		$this->db->insert('lab_order_results_tb',$resdata);

		return $outdata;
		
		
	}

}
?>