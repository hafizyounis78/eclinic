<?php
class Loginmodel extends CI_Model
{
	
	// Get All Users
	function verifyuser()
	{
		extract($_POST);
		
		/*$this->db->from('users_tb');
		$this->db->where("user_name", $username);
		$this->db->where('passward', MD5($password));*/
		
		
	$myquery = "SELECT  u.user_id, u.user_name, u.passward, u.employee_id, u.is_active, u.user_type_id, e.name
				  FROM  users_tb u, employee_tb e
				 WHERE  u.employee_id = e.employee_id
				   AND  u.user_name = '".$username."'
				  AND 	u.passward = '".MD5($password)."'";
		
		$res = $this->db->query($myquery);
		
		//$query = $res->result();
		//$query = $this->db->get();
		
		
		if ($res->num_rows() > 0)
		{
			
			$result = $res->result();
			$sess_array = array();
			 foreach($result as $row)
			 {
				 if ($row->is_active == 1)
				 {
					 $sess_array = array(
					   'userid' => $row->user_id,
					   'username' => $row->user_name,
					   'name' => $row->name
					 );
					 /*$menu_array = array(
										 
					 );*/
					 
					 $myquery ="SELECT m.menu_id, m.menu_name, m.menu_order, m.menu_icon, 
									   p.page_id, p.page_title, p.page_url, p.page_order, p.page_icon, p.show_in_menue,
									   mp.menu_page_id,
									   ump.user_menu_page_id, ump.user_type_id
								FROM   menu_tb m, page_tb p, menu_page_tb mp, user_menu_page_tb ump
								WHERE  mp.menu_id = m.menu_id
								AND    mp.page_id = p.page_id
								AND	   ump.menu_page_id = mp.menu_page_id
								AND	   ump.user_type_id = ".$row->user_type_id."
								AND	   m.menu_id != 1
								ORDER BY m.menu_order, p.page_order;";
					
					 $res = $this->db->query($myquery);
					 $menue = $res->result();
					 
					 $this->session->set_userdata('logged_in', $sess_array);
					 $this->session->set_userdata('menue', $menue);
					 return 1;
				 }
				 else
					return 2;
			   
			 }
			 
		}
		else
			return 0;
		
	}
}
?>