<?php

class Employeemodel extends CI_Model
{
	// Get All Employee
	function get_all_employee()
	{
		$this->db->from('employee_tb');
		$this->db->order_by("is_active", "DESC");
		$this->db->order_by("name", "ASC");
		
		$query = $this->db->get();
		
		return $query->result();
	}
	
	function check_employee_id()
	{
		extract($_POST);
		$national_id=$national_id;
		$myquery = "SELECT 	count(1) as cn
				  	FROM 	employee_tb
				  	WHERE 	national_id=$national_id";
		 return $this->db->query($myquery);
	}
	
	// Get All Employee do not have Account
	function get_employee_hasnt_account()
	{
		$myquery = "SELECT employee_id, name
				  	  FROM employee_tb
				  	 WHERE employee_id NOT IN ( SELECT employee_id FROM users_tb )";
		
		$res = $this->db->query($myquery);
		return $res->result();
	}
	// Search Employee 
	function search_employee_hasnt_account($empname)
	{
		$myquery = "SELECT employee_id, name, emp_id
				  	  FROM employee_tb
				  	 WHERE name LIKE '".$empname."%'
					   AND employee_id NOT IN ( SELECT employee_id FROM users_tb )
					   AND is_active = 1
				  ORDER BY name";
		
		$res = $this->db->query($myquery);
		return $res->result();
	}
	function get_employee_info($national_id)
	{
		$myquery = "SELECT 	national_id, emp_id, name , sex_id , job_title_id ,mobile,
							phone, email,is_active active_account,constjob.sub_constant_name
					FROM 	employee_tb, sub_constant_tb constjob
					WHERE 	employee_tb.job_title_id = constjob.sub_constant_id
					AND     national_id=$national_id";
		
		$res = $this->db->query($myquery);
		return $res->result();
	}
	// Insert New Employee
	function insert_employee()
	{
		extract($_POST);

		$data['national_id'] = $txtNationalId;
		$data['emp_id'] = $txtEmployeeId;
		$data['name'] = $txtName;
		$data['sex_id'] = $rdSex;
		$data['job_title_id'] = $drpJobtitle;
		$data['mobile'] = $txtMobile;
		$data['phone'] = $txtPhone;
		$data['email'] = $txtEmail;
		$data['is_active'] = $chbxIsactive;
		
		$this->db->insert('employee_tb',$data);
	}
	function update_employee()
	{
		extract($_POST);
		
		
		$data['national_id'] = $txtNationalId;
		$data['emp_id'] = $txtEmployeeId;
		$data['name'] = $txtName;
		$data['sex_id'] = $rdSex;
		$data['job_title_id'] = $drpJobtitle;
		$data['mobile'] = $txtMobile;
		$data['phone'] = $txtPhone;
		$data['email'] = $txtEmail;
		//$data['is_active'] = $is_active;
		if (isset($chbxIsactive))
			$data['is_active'] = 1;
		else
			$data['is_active'] = 0;
		
		$this->db->where('national_id',$txtNationalId);
		$this->db->update('employee_tb',$data);
	}
	
	function get_search_employee($requestData)
	{
		$columns = array( 
			1 => 'national_id',
			2 => 'emp_id',
			3 => 'name', 
			4 => 'job_title',
			5 => 'mobile',
			6 => 'email',
			7 => 'is_active');
		
		$myquery = "SELECT 	national_id,emp_id,name,mobile,employee_id,email,
							constjob.sub_constant_name job_title,job_title_id,is_active active_account
				      FROM  employee_tb,sub_constant_tb constjob
				     WHERE  job_title_id = constjob.sub_constant_id";
		
		if(isset($requestData['txtNationalid']) && $requestData['txtNationalid'] !='')
		{
			$myquery = $myquery." AND national_id = ".$requestData['txtNationalid'];
		}
		if(isset($requestData['txtEmpid']) && $requestData['txtEmpid'] !='')
		{
			$myquery = $myquery." AND emp_id = ".$requestData['txtEmpid'];
		}
		if(isset($requestData['txtName']) && $requestData['txtName'] !='')
		{
			$myquery = $myquery." AND name LIKE '%".$requestData['txtName']."%' ";
		}
		if(isset($requestData['drpJobtitle']) && $requestData['drpJobtitle'] !='')
		{
			$myquery = $myquery." AND job_title_id = ".$requestData['drpJobtitle'];
		}
		if(isset($requestData['txtMobile']) && $requestData['txtMobile'] !='')
		{
			$myquery = $myquery." AND mobile = LIKE '%".$requestData['txtMobile']."%' ";
		}
		
		if(isset($requestData['txtEmail']) && $requestData['txtEmail'] !='')
		{
			$myquery = $myquery." AND email = ".$requestData['txtEmail'];
		}
		if(isset($requestData['drpIsactive']) && $requestData['drpIsactive'] !='')
		{
			$myquery = $myquery." AND is_active = ".$requestData['drpIsactive'];
		}
		
		$myquery = $myquery." ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'].
					" LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
		
		$res = $this->db->query($myquery);
		return $res->result();
		
	}
	function count_employee()
	{
		return $this->db->count_all('employee_tb');		
	}

}
?>