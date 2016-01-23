<?php

class Patientmodel extends CI_Model
{
	function insert_patient()
	{
		extract($_POST);
		$data['org_id']     	    = "1";
		$data['patient_id'] 	  	= $txtPatientId;
		$data['first_name'] 		= $txtFname;
		$data['middle_name'] 		= $txtMname;
		$data['third_name'] 		= $txtThname;
		$data['last_name'] 			= $txtLname;
		$data['dob'] 				= $dpDob;
		$data['sex_id'] 			= $rdSex;
		$data['status_id'] 			= $drpstatus;
		$data['governorate_id'] 	= $drpGovernorate;
		$data['region_id'] 			= $drpRegion;
		$data['full_address'] 		= $drpFulladdress;
		$data['phone'] 				= $txtPhone;
		$data['mobile'] 		    = $txtMobile;

		$data['created_by'] = $_SESSION['username'];
		date_default_timezone_set('Asia/Gaza');
		$data['created_on'] = date("Y-m-d"); ;		 	
		/*
		// Insert file_tb
		$filedata['elder_id'] = $txtElderId;
		$filedata['file_doc_id'] = $txtFiledocId;
		$filedata['file_status_id'] = 170;
		$filedata['created_by'] = $_SESSION['username'];
		*/
		
		
		$this->db->insert('patient_mr_tb ',$data);
		$file_id = $this->db->insert_id();
		
		$outdata['patient_file_id']   = $file_id;

		return $outdata;
		
	}
	
	// Update Elder
	function update_patient()
	{
		extract($_POST);

		$data['patient_id']     	= $txtPatientId;
		$data['first_name'] 		= $txtFname;
		$data['middle_name'] 		= $txtMname;
		$data['third_name'] 		= $txtThname;
		$data['last_name'] 			= $txtLname;
		$data['dob'] 				= $dpDob;
		$data['sex_id'] 			= $rdSex;
		$data['status_id'] 			= $drpstatus;
		$data['governorate_id'] 	= $drpGovernorate;
		$data['region_id'] 			= $drpRegion;
		$data['full_address'] 		= $drpFulladdress;
		$data['phone'] 				= $txtPhone;
		$data['mobile'] 	  	    = $txtMobile;
		
		$this->db->where('patient_file_id',$hdnPatientFileId);
		$this->db->update('patient_mr_tb',$data);
		
		
		
		return;
		
	}

	
	
	// Get Elder By ID
	
	
	function get_patient_by_id($patientid ='')
	{
		// Get elder id from POST otherwise get elder id from function arg $elderid
		if ( !empty($_POST) )
		{
			extract($_POST);
			$elderid = $elder_id;
		}
		
		$myquery = "SELECT 	p.patient_file_id,p.patient_id,p.first_name, p.middle_name, 
							p.third_name, p.last_name,
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

	function get_patient_nutrition_info($patientid ='')
	{
		// Get elder id from POST otherwise get elder id from function arg $elderid
		if ( !empty($_POST) )
		{
			extract($_POST);
			$elderid = $elder_id;
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
	function get_search_patient($requestData)
	{
		$columns = array( 
			1 => 'patient_file_id',
			2 => 'patient_id',
			3 => 'name',
			4 => 'phone', 
			5 => 'mobile',
			6 => 'Patient_governorate');
		
		$myquery = "SELECT 	patient_file_id,patient_id,_id,CONCAT(first_name,' ',middle_name,' ',third_name,' ',last_name) as name,
							phone,mobile,governconst.sub_constant_name as Patient_governorate 
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
		
		if(isset($requestData['txtPatientName']) && $requestData['txtPatientName'] !='')
		{
			$myquery = $myquery." AND CONCAT(first_name,' ',middle_name,' ',third_name,' ',last_name)
			LIKE '%".$requestData['txtPatientName']."%' ";
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
	function count_elder()
	{
		return $this->db->count_all('patient_mr_tb');			
	}

}
?>