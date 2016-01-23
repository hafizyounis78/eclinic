<?php
class Usermodel extends CI_Model
{
	function get_user_info($username)
	{
		$myquery = "SELECT u.user_name, u.passward, u.employee_id, u.is_active active_account, 
						   u.user_type_id, constutype.sub_constant_name user_type, u.created_on, u.created_by,
					       emp.emp_id, emp.name, emp.job_title_id, constjob.sub_constant_name job_title
				      FROM users_tb u, employee_tb emp, sub_constant_tb constutype, sub_constant_tb constjob
				     WHERE u.employee_id = emp.employee_id
				  	   AND u.user_type_id = constutype.sub_constant_id
					   AND emp.job_title_id = constjob.sub_constant_id
					   AND u.user_name = '".$username."'";
		
		$res = $this->db->query($myquery);
		return $res->result();
	}
	// Get All Users
	function get_search_users($requestData)
	{
		$columns = array( 
			1 => 'u.user_name', 
			2 => 'u.employee_id',
			3 => 'emp.name',
			4 => 'job_title',
			5 => 'user_type',
			6 => 'u.is_active');
		
		$myquery = "SELECT u.user_name, u.employee_id, u.is_active active_account, 
						   u.user_type_id, constutype.sub_constant_name user_type, u.created_on, u.created_by,
					       emp.emp_id, emp.name, emp.job_title_id, constjob.sub_constant_name job_title
				      FROM users_tb u, employee_tb emp, sub_constant_tb constutype, sub_constant_tb constjob
				     WHERE u.employee_id = emp.employee_id
				  	   AND u.user_type_id = constutype.sub_constant_id
					   AND emp.job_title_id = constjob.sub_constant_id";
		
		if(isset($requestData['txtUsername']) && $requestData['txtUsername'] !='')
		{
			$myquery = $myquery." AND u.user_name LIKE '%".$requestData['txtUsername']."%' ";
		}
		if(isset($requestData['txtEmpid']) && $requestData['txtEmpid'] !='')
		{
			$myquery = $myquery." AND emp.emp_id = ".$requestData['txtEmpid'];
		}
		if(isset($requestData['txtName']) && $requestData['txtName'] !='')
		{
			$myquery = $myquery." AND emp.name = LIKE '%".$requestData['txtName']."%' ";
		}
		if(isset($requestData['drpJobtitle']) && $requestData['drpJobtitle'] !='')
		{
			$myquery = $myquery." AND emp.job_title_id = ".$requestData['drpJobtitle'];
		}
		if(isset($requestData['drpUsertype']) && $requestData['drpUsertype'] !='')
		{
			$myquery = $myquery." AND u.user_type_id = ".$requestData['drpUsertype'];
		}
		if(isset($requestData['drpIsactive']) && $requestData['drpIsactive'] !='')
		{
			$myquery = $myquery." AND u.is_active = ".$requestData['drpIsactive'];
		}
		
		$myquery = $myquery." ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'].
					" LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
		
		$res = $this->db->query($myquery);
		return $res->result();
		
	}
	function count_users()
	{
		return $this->db->count_all('users_tb');
	}
	// Insert User
	function user_insart()
	{
		extract($_POST);
		$data['user_name'] = $txtUsername;
		$data['passward'] = MD5($txtPassword);
		$data['employee_id'] = $hdnEmployeeId;
		$data['is_active'] = $chbxIsactive;
		$data['user_type_id'] = $drpUsertype;
		//$data['created_by'] = $_SESSION['username'];
		
		$this->db->insert('users_tb',$data);
	}
	// Update User
	function user_update()
	{
		extract($_POST);
		if (isset($chbxIsactive))
			$data['is_active'] = 1;
		else
			$data['is_active'] = 0;
			
		$data['user_type_id'] = $drpUsertype;
		
		$this->db->where('user_name',$txtUsername);
		$this->db->update('users_tb',$data);
	}
	
	// Enable/Disable Account
	function update_account_status()
	{
		extract($_POST);
		$data['is_active'] = $isactive;
		
		$this->db->where('user_name',$username);
		$this->db->update('users_tb',$data);
	}
	
	// Reset Password
	function reset_password()
	{
		extract($_POST);
		$data['passward'] = MD5('123456');
		
		$this->db->where('user_name',$username);
		$this->db->update('users_tb',$data);
	}
	
	// Check Availabile Username
	function check_username()
	{
		extract($_POST);
		
		$this->db->from('users_tb');
		$this->db->where('user_name',$username);
		$query = $this->db->get();
		
		return $query->result();
		
	}
	
}
?>