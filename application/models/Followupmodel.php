<?php

class Followupmodel extends CI_Model
{
	function get_followup_by_elderid($elderid)
	{
		$myquery = "SELECT  follow_up_id, researcher_id,visit_date, visit_time, visit_end_time, visit_reason,notes,
							recommendation, employee_tb.name as Researcher_name
					  FROM  follow_up_tb,employee_tb
					 WHERE  follow_up_tb.researcher_id = employee_tb.employee_id
					   AND  follow_up_tb.elder_id = " . $elderid . "
				  ORDER BY  visit_date DESC";
		
		$res = $this->db->query($myquery);
		return $res->result();
		
	}
	// Get Elder By ID
	function get_elder_byid($elderid)
	{
		$myquery = "SELECT	e.elder_id,CONCAT(e.first_name,' ',e.middle_name,' ',e.third_name,' ',e.last_name) as name
					FROM 	elder_tb e
					WHERE 	e.elder_id = ".$elderid;
		
		$res = $this->db->query($myquery);
		return $res->result();
		
	}
	function insert_followup()
	{
		extract($_POST);

		$data['elder_id'] = $txtElderId;
		$data['researcher_id'] = $drpResearcher;
		$data['visit_date'] = $dpVisitdate;
		$data['visit_time'] = $txtVisittime;
		$data['visit_end_time'] = $txtVisitendtime;
		$data['visit_reason'] = $txtVisitreason;
		$data['notes'] = $txtnotes;
		$data['recommendation'] = $txtRecommendation;
		
		$this->db->insert('follow_up_tb',$data);

	}
		function update_followup()
	{
		extract($_POST);

		$data['elder_id'] = $txtElderId;
		$data['researcher_id'] = $drpResearcher;
		$data['visit_date'] = $dpVisitdate;
		$data['visit_time'] = $txtVisittime;
		$data['visit_end_time'] = $txtVisitendtime;
		$data['visit_reason'] = $txtVisitreason;
		$data['notes'] = $txtnotes;
		$data['recommendation'] = $txtRecommendation;
			
		$this->db->where('follow_up_id',$hdnfollowupId);
		$this->db->update('follow_up_tb',$data);

	}
	
	function delete_followup()
	{
		extract($_POST);
		
		$this->db->where('follow_up_id',$hdnfollowupId);
		$this->db->delete('follow_up_tb');
	}
	
//end Get Elder id
}
?>