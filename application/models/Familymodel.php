<?php

class Familymodel extends CI_Model
{
	//*********************get elder name and survey ID**********//	
	function get_elder_by_id($elderid)
	{
		// Get elder id from POST otherwise get elder id from function arg $elderid
		
		
		$myquery = "SELECT	e.elder_id, s.survey_id, CONCAT(e.first_name,' ',e.middle_name,' ',e.third_name,' ',e.last_name) as name
					FROM 	elder_tb e, survey_tb s, file_tb f
					WHERE 	e.elder_id = f.elder_id
					  AND	f.file_id  = s.file_id
					  AND   e.elder_id = ".$elderid;
		
		$res = $this->db->query($myquery);
		return $res->result();
		
	}
	
//end get elder name and survey ID

/************************ FAMILY MEMBER TAB ***************************/
/*	Insert Family Member							  				  */
/*	Update Family Member							  				  */
/*	Delete Family Member							  				  */
/*	Get Family Member By Survey ID							  		  */
/**********************************************************************/

	// Insert Family Member
	function insert_familyMember()
	{
		extract($_POST);
		
		$data['survey_id'] 		  = $hdnSurveyId;
		$data['elder_id'] 		  = $txtElderId;
		$data['member_id'] 		  = $txtMemberId;
		$data['member_name'] 	  = $txtMembername;
		$data['member_sex_id'] 	  = $rdMemSex;
		$data['relationship_id']  = $drpMemRelationship;
		$data['status_id'] 		  = $drpMemStatus;
		$data['dob'] 			  = $dpMemDob;
		$data['education_level_id']  = $drpMemEdulevel;
		$data['health_status_id'] = $drpMemHealth;
		$data['job'] 			  = $txtMemjob;
		
		if($txtMemincome == '')
			$data['income_shekel'] 	  = NULL;
		
		$this->db->insert('family_member_tb',$data);
	}
	
	function update_familyMember()
	{
		extract($_POST);
		//$data['family_member_id'] = $txtFname;
		//$data['elder_id'] = $txtElderId;
		//$data['member_id'] = $txtMemberId;
		$data['member_name'] = $txtMembername;
		$data['member_sex_id'] = $rdMemSex;
		$data['relationship_id'] = $drpMemRelationship;
		$data['status_id'] = $drpMemStatus;
		$data['dob'] = $dpMemDob;
		$data['education_level_id'] = $drpMemEdulevel;
		$data['health_status_id'] = $drpMemHealth;
		$data['job'] = $txtMemjob;
		
		if($txtMemincome == '')
			$data['income_shekel'] 	  = NULL;
		
		$this->db->where('member_id',$txtMemberId);
		$this->db->update('family_member_tb',$data);
	}
	
	// Delete Family Member
	function delete_familyMember()
	{
		extract($_POST);
		
		$this->db->where('family_member_id',$familymemberid);
		$this->db->delete('family_member_tb');
	}
	
	function check_familyMember_id()
	{	extract($_POST);
		$this->db->where('member_id',$member_id);
		$query = $this->db->get('family_member_tb');
		return $query->result();
		
	}
	function get_familyMember_by_elder_id($elder_id)
	{
		
		
		$myquery = "SELECT fm.family_member_id, fm.survey_id, fm.elder_id, fm.member_id, fm.member_name, fm.dob, fm.income_shekel, 		
						fm.job, fm.member_sex_id, sex.sub_constant_name sex,
        				fm.relationship_id, rel.sub_constant_name relationship,
        				fm.status_id, stat.sub_constant_name fmstatus,
        				fm.education_level_id, edu.sub_constant_name education_level,
        				fm.health_status_id, hlt.sub_constant_name health_status
					 FROM family_member_tb fm
					  LEFT OUTER JOIN sub_constant_tb sex  ON fm.member_sex_id      = sex.sub_constant_id
					  LEFT OUTER JOIN sub_constant_tb rel  ON fm.relationship_id    = rel.sub_constant_id
					  LEFT OUTER JOIN sub_constant_tb stat ON fm.status_id          = stat.sub_constant_id
					  LEFT OUTER JOIN sub_constant_tb edu  ON fm.education_level_id = edu.sub_constant_id
					  LEFT OUTER JOIN sub_constant_tb hlt  ON fm.health_status_id 	= hlt.sub_constant_id
				  WHERE fm.elder_id = ".$elder_id;
		
		$res = $this->db->query($myquery);
		return $res->result();
	}
//----------------------- END FAMILY MEMBER TAB ------------------------/	
}
?>