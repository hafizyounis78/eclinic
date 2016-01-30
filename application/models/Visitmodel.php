<?php

class Visitmodel extends CI_Model
{
	function insert_visit()
	{
		extract($_POST);
		$data['org_id']     	    = "1";
		$data['clinic_id'] 		= 1;
		$data['patient_file_id'] 	= $txtPatientFileId;
		$data['visit_date'] 		= $dpVisitdate;
		$data['visit_type_id'] 		= $drpVisitType;
		date_default_timezone_set('Asia/Gaza');
		$data['visit_time'] =date("H:i:s");
		
		/*$sdata = $this->session->userdata('logged_in');
		$data['created_by'] = $sdata['userid'];
		date_default_timezone_set('Asia/Gaza');
		$data['created_on'] =date("Y-m-d H:i:s");	 	
		*/
		
		$this->db->insert('outpatient_visits_tb ',$data);
		$visit_id = $this->db->insert_id();
		
		$outdata['visit_id']   = $visit_id;
		
		// Insert body_segment_tb
		
		$bodydata['outpatient_visit_id'] = $visit_id;
		$bodydata['weight'] = $txtWeight;
		$bodydata['length'] = $txtLength;
		$bodydata['bmi'] = $txtBmi;
		$this->db->insert('body_segment_tb',$bodydata);
		
		// Insert outpatient_nutrition_plan_tb
		
		$nutdata['outpatient_visit_id'] = $visit_id;
		$nutdata['plan_id'] = $drpPlan;
		$nutdata['start_date'] = $dpStartdate;
		$nutdata['end_date'] = $dpEnddate;
		$nutdata['notes'] = $txtNotes;
		$this->db->insert('outpatient_nutrition_plan_tb',$nutdata);

		return $outdata;
		
	}
	
	// Update visit
	function update_visit()
	{
		extract($_POST);
			
		
		// Update body_segment_tb
		
		//$bodydata['outpatient_visit_id'] = $visit_id;
		$bodydata['weight'] = $txtWeight;
		$bodydata['length'] = $txtLength;
		$bodydata['bmi'] = $txtBmi;
		$this->db->where('outpatient_visit_id',$visit_id);
		$this->db->update('body_segment_tb',$bodydata);
		
		// Update outpatient_nutrition_plan_tb
		
		$nutdata['outpatient_visit_id'] = $visit_id;
		$nutdata['plan_id'] = $drpPlan;
		$nutdata['start_date'] = $dpStartdate;
		$nutdata['end_date'] = $dpEnddate;
		$nutdata['notes'] = $txtNotes;
		$this->db->where('outpatient_visit_id',$visit_id);
		$this->db->update('outpatient_nutrition_plan_tb',$nutdata);
		
		return;
		
	}

	
	
	// Get vists By ID
	
	
	function get_visit_by_id($visitId ='')
	{
		// Get elder id from POST otherwise get elder id from function arg $elderid
		if ( !empty($_POST) )
		{
			extract($_POST);
			$visitId= $visitId;
		}
		//outpatient_nutrition_plan_tb
		//body_segment_tb
		//outpatient_visits_tb
		$myquery = "SELECT 	p.patient_file_id,p.patient_id,CONCAT(first_name,' ',middle_name,' ',third_name,' ',last_name) as name,visit.sub_constant_name as visit_desc
					 FROM 	outpatient_visits_tb
					 LEFT 	OUTER JOIN sub_constant_tb visit  ON outpatient_visits_tb.visit_type_id= visit.sub_constant_id
					,patient_mr_tb p,body_segment_tb,outpatient_nutrition_plan_tb
					 WHERE 	outpatient_visits_tb.patient_file_id=p.patient_file_id
					 and 	outpatient_visits_tb.outpatient_visit_id=body_segment_tb.outpatient_visit_id
					 and 	outpatient_visits_tb.outpatient_visit_id=outpatient_nutrition_plan_tb.outpatient_visit_id
					 and 	outpatient_visits_tb.outpatient_visit_id=".$visitId;
		
		$res = $this->db->query($myquery);
		return $res->result();
		
	}
	function get_patient_by_id($patientFileId ='')
	{
		// Get elder id from POST otherwise get elder id from function arg $elderid
		if ( !empty($_POST) )
		{
			extract($_POST);
			$patientFileNo= $patientFileId;
		}
		
		$myquery = "SELECT 	p.patient_file_id,p.patient_id,CONCAT(first_name,' ',middle_name,' ',third_name,' ',last_name) as name,
							p.dob
					 FROM 	patient_mr_tb p
					 WHERE p.patient_file_id = ".$patientFileId;
		
		$res = $this->db->query($myquery);
		return $res->result();
		
	}


	function get_patient_nutrition_info($patientid ='')
	{
		// Get elder id from POST otherwise get elder id from function arg $elderid
		if ( !empty($_POST) )
		{
			extract($_POST);
			$elderid = $patientFileId;
		}
		
		$myquery = "SELECT 	p.patient_file_id,p.patient_id,p.first_name, p.middle_name, 
							p.third_name, p.last_name	,
							p.dob, p.sex_id, p.status_id, p.governorate_id,p.region,p.full_address,
							reg.sub_constant_name as region_desc,
							address.sub_constant_name as fulladdress,
							p.phone,p.mobile
					 FROM 	patient_mr_tb p
					 LEFT 	OUTER JOIN sub_constant_tb gov  ON p.governorate_id= gov.sub_constant_id
					 LEFT 	OUTER JOIN sub_constant_tb reg  ON p.region= reg.sub_constant_id
					 LEFT 	OUTER JOIN sub_constant_tb address  ON p.full_address= address.sub_constant_id
							
					WHERE p.patient_id = ".$patientId;
		
		$res = $this->db->query($myquery);
		return $res->result();
		
	}
	
	// Get All Elders
	function get_search_visits($requestData)
	{
		$columns = array( 
			1 => 'patient_file_id',
			2 => 'patient_id',
			3 => 'name',
			4 => 'phone', 
			5 => 'mobile',
			6 => 'Patient_governorate',
			7 => 'last_visit');
		
		$myquery = "SELECT 	patient_file_id,patient_id,CONCAT(first_name,' ',middle_name,' ',third_name,' ',last_name) as name,
							phone,mobile,created_on as last_visit,governconst.sub_constant_name as Patient_governorate 
 					FROM 	patient_mr_tb ,sub_constant_tb governconst
					WHERE 	patient_mr_tb.governorate_id=governconst.sub_constant_id";
		
		if(isset($requestData['txtPatientFileid']) && $requestData['txtPatientFileid'] !='')
		{
			$myquery = $myquery." AND patient_file_id = ".$requestData['txtPatientFileid'];
		}
		if(isset($requestData['txtPatientid']) && $requestData['txtPatientid'] !='')
		{
			$myquery = $myquery." AND patient_id = ".$requestData['txtPatientid'];
		}
		
		if(isset($requestData['txtName']) && $requestData['txtName'] !='')
		{
			$myquery = $myquery." AND CONCAT(first_name,' ',middle_name,' ',third_name,' ',last_name)
			LIKE '%".$requestData['txtName']."%' ";
		}
		if(isset($requestData['txtPhone']) && $requestData['txtPhone'] !='')
		{
			$myquery = $myquery." AND phone = ".$requestData['txtPhone'];
		}
		if(isset($requestData['txtMobile']) && $requestData['txtMobile'] !='')
		{
			$myquery = $myquery." AND mobile= ".$requestData['txtMobile'];
		}
		
		if(isset($requestData['drpGovernorate']) && $requestData['drpGovernorate'] !='')
		{
			$myquery = $myquery." AND governconst.sub_constant_id = ".$requestData['drpGovernorate'];
		}
		$myquery = $myquery." ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'].
					" LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
		
		$res = $this->db->query($myquery);
		return $res->result();
		
	}
	function count_patients()
	{
		return $this->db->count_all('patient_mr_tb');			
	}

}
?>