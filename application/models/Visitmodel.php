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
		
		/*$nutdata['outpatient_visit_id'] = $visit_id;
		$nutdata['plan_id'] = $drpPlan;
		$nutdata['start_date'] = $dpStartdate;
		$nutdata['end_date'] = $dpEnddate;
		$nutdata['breakfast'] = $txtbreakfast;
		$nutdata['lunch'] = $txtlunch;
		$nutdata['dinner'] = $txtdinner;
		$nutdata['notes'] = $txtNotes;
		$this->db->insert('outpatient_nutrition_plan_tb',$nutdata);*/

		return $outdata;
		
	}
	
	// Update visit
	function update_visit()
	{
		extract($_POST);
			
		//update visit type 
			$data['visit_type_id'] 		= $drpVisitType;
		$this->db->where('outpatient_visit_id',$hdnvisitNo);
		$this->db->update('outpatient_visits_tb',$data);	
		
		// Update body_segment_tb
		
		//$bodydata['outpatient_visit_id'] = $hdnvisitNo;
		$bodydata['weight'] = $txtWeight;
		$bodydata['length'] = $txtLength;
		$bodydata['bmi'] = $txtBmi;
		$this->db->where('outpatient_visit_id',$hdnvisitNo);
		$this->db->update('body_segment_tb',$bodydata);
		
		// Update outpatient_nutrition_plan_tb
		
	//	$nutdata['outpatient_visit_id'] = $hdnvisitNo;
		$nutdata['plan_id'] = $drpPlan;
		$nutdata['start_date'] = $dpStartdate;
		$nutdata['end_date'] = $dpEnddate;
		$nutdata['breakfast'] = $txtbreakfast;
		$nutdata['lunch'] = $txtlunch;
		$nutdata['dinner'] = $txtdinner;
		$nutdata['notes'] = $txtNotes;

		$this->db->where('outpatient_visit_id',$hdnvisitNo);
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
		$myquery = "SELECT 	p.patient_file_id,p.patient_id,CONCAT(first_name,' ',middle_name,' ',third_name,' ',last_name) as name,visit.sub_constant_name as visit_desc, dob
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
		
		$myquery = "SELECT 	patient_file_id,patient_id,CONCAT(first_name,' ',middle_name,' ',third_name,' ',last_name) as name,
							dob
					 FROM 	patient_mr_tb p
					 WHERE  patient_file_id = ".$patientFileId;
		
		$res = $this->db->query($myquery);
		print_r($res );
		return $res->result();

	}
function get_nut_plan_by_id($planId ='')
	{
		// Get elder id from POST otherwise get elder id from function arg $elderid
		if ( !empty($_POST) )
		{
			extract($_POST);
			$planId= $planCode;
		}
		
		$myquery = "SELECT 	breakfast,lunch,dinner
					 FROM 	nutrition_plan_tb 
					 WHERE  plan_id = ".$planId;
		
		$res = $this->db->query($myquery);
		//print_r($res->result());
		return $res->result();
	}
function get_nut_plan_list()
	{
		// Get nutration plan list

		$myquery = "SELECT 	plan_id,plan_desc_a,plan_desc_e
					 FROM 	nutrition_plan_tb";
		
		$res = $this->db->query($myquery);
	//	print_r($res );
		return $res->result();

	}


	function get_patient_nutrition_info($patientid ='')
	{
		// Get elder id from POST otherwise get elder id from function arg $elderid
		if ( !empty($_POST) )
		{
			extract($_POST);
			$patientId = $patientFileId;
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
			1 => 'outpatient_visit_id',
			2 => 'patient_id',
			3 => 'name',
			4 => 'weight', 
			5 => 'length',
			6 => 'bmi',
			7 => 'visit_type',
			8 => 'visit_date');
		
		$myquery = "SELECT 	 	v.outpatient_visit_id,v.patient_file_id,CONCAT(p.first_name,' ',p.middle_name,' ',p.third_name,' ',p.last_name) as name,
							visit_date,visitconst.sub_constant_name as visit_type,b.weight,b.length,b.bmi 
 					FROM    outpatient_visits_tb v	
					LEFT 	OUTER JOIN sub_constant_tb visitconst  ON v.visit_type_id= visitconst.sub_constant_id
							,patient_mr_tb p ,body_segment_tb b
					WHERE 	v.patient_file_id=p.patient_file_id
					AND 	v.outpatient_visit_id=b.outpatient_visit_id";
		
		if(isset($requestData['txtVisitid']) && $requestData['txtVisitid'] !='')
		{
			$myquery = $myquery." AND v.outpatient_visit_id = ".$requestData['txtVisitid'];
		}
		if(isset($requestData['txtPatientFileid']) && $requestData['txtPatientFileid'] !='')
		{
			$myquery = $myquery." AND v.patient_file_id = ".$requestData['txtPatientFileid'];
		}
		
		
		if(isset($requestData['txtName']) && $requestData['txtName'] !='')
		{
			$myquery = $myquery." AND CONCAT(first_name,' ',middle_name,' ',third_name,' ',last_name)
			LIKE '%".$requestData['txtName']."%' ";
		}
		if(isset($requestData['txtWeight']) && $requestData['txtWeight'] !='')
		{
			$myquery = $myquery." AND weight = ".$requestData['txtWeight'];
		}
		if(isset($requestData['txtLength']) && $requestData['txtLength'] !='')
		{
			$myquery = $myquery." AND length= ".$requestData['txtLength'];
		}
		if(isset($requestData['txtBmi']) && $requestData['txtBmi'] !='')
		{
			$myquery = $myquery." AND bmi= ".$requestData['txtBmi'];
		}
		/*******************************************************************/
		if(isset($requestData['dpVisitfrom']) && $requestData['dpVisitfrom'] != ''
		   && isset($requestData['dpVisitto']) && $requestData['dpVisitto'] != '')
		{
			$myquery = $myquery." AND visit_date between '".$requestData['dpVisitfrom']."' and '".$requestData['dpVisitto']."'";
		}
		if(isset($requestData['dpVisitfrom']) && $requestData['dpVisitfrom'] != ''
		   && (isset($requestData['dpVisitto']) && $requestData['dpVisitto'] == ''))
		{
			$myquery = $myquery." AND visit_date >= '".$requestData['dpVisitfrom']."'";
		}

		
		//*****************************************************************//
		
		
		if(isset($requestData['drpVisitType']) && $requestData['drpVisitType'] !='')
		{
			$myquery = $myquery." AND visit_type_id = ".$requestData['drpVisitType'];
		}
		$myquery = $myquery." ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'].
					" LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
		
		$res = $this->db->query($myquery);
		return $res->result();
		
	}
	function count_visits()
	{
		return $this->db->count_all('outpatient_visits_tb');			
	}
function get_visit_data_by_id($VisitNo)
{
	//extract($_POST);
	//$Visitid = $VisitNo;
	//print_r($VisitNo);
	$myquery = "SELECT 	 	v.outpatient_visit_id,p.patient_file_id,CONCAT(p.first_name,' ',p.middle_name,' ',p.third_name,' ',p.last_name) as name,dob,
							v.visit_date,v.visit_time,v.visit_type_id,b.weight,b.length,b.bmi,n.plan_id,n.start_date,n.end_date,n.breakfast,n.lunch,n.dinner ,n.notes
 					FROM    outpatient_visits_tb v
					LEFT 	OUTER JOIN body_segment_tb b  ON v.outpatient_visit_id= b.outpatient_visit_id
					LEFT 	OUTER JOIN outpatient_nutrition_plan_tb n ON v.outpatient_visit_id=n.outpatient_visit_id
					,patient_mr_tb p
					WHERE 	v.patient_file_id=p.patient_file_id
					and     v.outpatient_visit_id=".$VisitNo;
		
		
		$res = $this->db->query($myquery);
//		print_r($res->result());
		return $res->result();
		
		
}

}
?>