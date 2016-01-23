<?php

class Eldermodel extends CI_Model
{
	
	// Get Elder By ID
	function get_elder_by_id($elderid ='')
	{
		// Get elder id from POST otherwise get elder id from function arg $elderid
		if ( !empty($_POST) )
		{
			extract($_POST);
			$elderid = $elder_id;
		}
		
		$myquery = "SELECT 	e.elder_id, e.elder_category_id, e.first_name, e.middle_name, 
							e.third_name, e.last_name,
							e.dob, e.sex_id, e.status_id, e.governorate_id,e.region,e.full_address,
							reg.sub_constant_name as region_desc,
							address.sub_constant_name as fulladdress,
							e.phone, e.address_details,
        					e.mobile_first, e.mobile_second, e.education_level_id, e.specialization_id, 
        					e.current_job_id, e.previous_job_id, e.insurance_type_id, e.death_date,
        					f.file_id, f.file_doc_id, f.file_status_id
					 FROM 	elder_tb e
					 LEFT 	OUTER JOIN sub_constant_tb gov  ON e.governorate_id= gov.sub_constant_id
					 LEFT 	OUTER JOIN sub_constant_tb reg  ON e.region= reg.sub_constant_id
					 LEFT 	OUTER JOIN sub_constant_tb address  ON e.full_address= address.sub_constant_id
							, file_tb f
					WHERE e.elder_id = f.elder_id
					  AND e.elder_id = ".$elderid;
		
		$res = $this->db->query($myquery);
		return $res->result();
		
	}
	
	// Get All Elders
	function get_search_elder($requestData)
	{
		$columns = array( 
			1 => 'elder_id',
			2 => 'name',
			3 => 'phone', 
			4 => 'mobile_first',
			5 => 'mobile_second',
			6 => 'Eder_governorate',
			7 => 'isDeadElder');
		
		$myquery = "SELECT 	elder_id,CONCAT(first_name,' ',middle_name,' ',third_name,' ',last_name) as name,
							phone,mobile_first, mobile_second,
							CASE WHEN death_date IS null then 1 ELSE  0 END AS  isDeadElder,
							governconst.sub_constant_name as Eder_governorate 
 					FROM 	elder_tb ,sub_constant_tb governconst
					WHERE 	elder_tb.governorate_id=governconst.sub_constant_id";
		
		if(isset($requestData['txtElderid']) && $requestData['txtElderid'] !='')
		{
			$myquery = $myquery." AND elder_id = ".$requestData['txtElderid'];
		}
		
		if(isset($requestData['txtElderName']) && $requestData['txtElderName'] !='')
		{
			$myquery = $myquery." AND CONCAT(first_name,' ',middle_name,' ',third_name,' ',last_name)
			LIKE '%".$requestData['txtElderName']."%' ";
		}
		if(isset($requestData['txtPhone']) && $requestData['txtPhone'] !='')
		{
			$myquery = $myquery." AND phone = ".$requestData['txtPhone'];
		}
		if(isset($requestData['txtMobile1']) && $requestData['txtMobile1'] !='')
		{
			$myquery = $myquery." AND mobile_first = ".$requestData['txtMobile1'];
		}
		if(isset($requestData['txtMobile2']) && $requestData['txtMobile2'] !='')
		{
			$myquery = $myquery." AND mobile_second = LIKE '%".$requestData['txtMobile2']."%' ";
		}
		
		if(isset($requestData['drpGovernorate']) && $requestData['drpGovernorate'] !='')
		{
			$myquery = $myquery." AND governconst.sub_constant_id = ".$requestData['drpGovernorate'];
		}
		if(isset($requestData['drpisDead']) && $requestData['drpisDead'] !='')
		{ 
			if($requestData['drpisDead'] == 1 )
			{
				$myquery = $myquery." AND death_date is null ";
			}
			else if($requestData['drpisDead'] == 0 )
			{
				$myquery = $myquery." AND death_date is not null  ";
			}
		}
		$myquery = $myquery." ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'].
					" LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
		
		$res = $this->db->query($myquery);
		return $res->result();
		
	}
	function count_elder()
	{
		return $this->db->count_all('elder_tb');			
	}

}
?>