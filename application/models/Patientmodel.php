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
		
		$sdata = $this->session->userdata('logged_in');
		$data['created_by'] = $sdata['userid'];
		date_default_timezone_set('Asia/Gaza');
		$data['created_on'] =date("Y-m-d H:i:s");	 	
		/*
		// Insert file_tb
		$filedata['elder_id'] = $txtElderId;
		$filedata['file_doc_id'] = $txtFiledocId;
		$filedata['file_status_id'] = 170;
		$filedata['created_by'] = $_SESSION['username'];
		*/
		
		
		$this->db->insert('patient_mr_tb ',$data);
		$patientFile_id = $this->db->insert_id();
		
		$outdata['patient_file_id']   = $patientFile_id;

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
	
	
	function get_patient_by_id($patientFileId ='')
	{
		// Get elder id from POST otherwise get elder id from function arg $elderid
		if ( !empty($_POST) )
		{
			extract($_POST);
			$patientFileNo= $patientFileId;
		}
		
		$myquery = "SELECT 	p.patient_file_id,p.patient_id,p.first_name, p.middle_name, 
							p.third_name, p.last_name,
							p.dob, p.sex_id, p.status_id, p.governorate_id,p.region_id,p.full_address,
							reg.sub_constant_name as region_desc,
							address.sub_constant_name as fulladdress,
							p.phone,p.mobile
					 FROM 	patient_mr_tb p
					 LEFT 	OUTER JOIN sub_constant_tb gov  ON p.governorate_id= gov.sub_constant_id
					 LEFT 	OUTER JOIN sub_constant_tb reg  ON p.region_id= reg.sub_constant_id
					 LEFT 	OUTER JOIN sub_constant_tb address  ON p.full_address= address.sub_constant_id
							
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
	function get_search_patient($requestData)
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
//***********patientList**//

function get_patient_list($requestData)
	{
		date_default_timezone_set('Asia/Gaza');   
		$today_date = date('Y-m-d');

		$columns = array( 
			1 => 'patient_file_id',
			2 => 'name',
			3 => 'visit_date', 
			4 => 'visitType',
			5 => 'visitStatus');
		
		$myquery = "SELECT 	p.patient_file_id,CONCAT(first_name,' ',middle_name,' ',third_name,' ',last_name) as name,
							visit_date,visit_time,visit_status_id,visit_type_id,outpatient_visit_id,
							visitStatustb.sub_constant_name as visitStatus,visitTypetb.sub_constant_name as visitType
 					FROM 	patient_mr_tb p,outpatient_visits_tb v,sub_constant_tb visitTypetb,sub_constant_tb visitStatustb
					WHERE 	p.patient_file_id=v.patient_file_id
					and     v.visit_type_id=visitTypetb.sub_constant_id
					and     v.visit_status_id=visitStatustb.sub_constant_id";
		
		if(isset($requestData['txtPatientFileid']) && $requestData['txtPatientFileid'] !='')
		{
			$myquery = $myquery." AND patient_file_id = ".$requestData['txtPatientFileid'];
		}
			
		if(isset($requestData['txtName']) && $requestData['txtName'] !='')
		{
			$myquery = $myquery." AND CONCAT(first_name,' ',middle_name,' ',third_name,' ',last_name)
			LIKE '%".$requestData['txtName']."%' ";
		}
		
		if(isset($requestData['drpVisitType']) && $requestData['drpVisitType'] !='')
		{
			$myquery = $myquery." AND visit_type_id= ".$requestData['drpVisitType'];
		}
		
		if(isset($requestData['drpVisitStatus']) && $requestData['drpVisitStatus'] !='')
		{
			$myquery = $myquery." AND visit_status_id = ".$requestData['drpVisitStatus'];
		}
		
		//***************
		
		if(!isset($requestData['dpVistfrom'])&& !isset($requestData['dpVisitto']) )
		{
			$myquery = $myquery." AND DATE_FORMAT(v.visit_date,'%Y-%m-%d')>= '$today_date'";
		}
		if(isset($requestData['dpVistfrom']) && $requestData['dpVistfrom'] == '' 
		&& isset($requestData['dpVisitto']) && $requestData['dpVisitto'] == '' )
		{
			$myquery = $myquery." AND DATE_FORMAT(v.visit_date,'%Y-%m-%d')>= '$today_date'";
		}
		if(isset($requestData['dpVistfrom']) && $requestData['dpVistfrom'] != ''
		   && isset($requestData['dpVisitto']) && $requestData['dpVisitto'] != '')
		{
			$myquery = $myquery." AND visit_date between '".$requestData['dpVistfrom']."' and '".$requestData['dpVisitto']."'";
		}
		if(isset($requestData['dpVistfrom']) && $requestData['dpVistfrom'] != ''
		   && (isset($requestData['dpVisitto']) && $requestData['dpVisitto'] == ''))
		{
			$myquery = $myquery." AND visit_date >= '".$requestData['dpVistfrom']."'";
		}
		//************
		$myquery = $myquery." ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'].
					" LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
		
		$res = $this->db->query($myquery);
		return $res->result();
		
	}
	function count_patientsList()
	{
		return $this->db->count_all('patient_mr_tb');			
	}

}
?>