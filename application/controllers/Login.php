<?php
class Login extends CI_Controller 
{
	
	function verifylogin()
	{
		$this->load->model('loginmodel','',TRUE);
		$res = $this->loginmodel->verifyuser();
		
		echo $res;
		
		/*$sess_array = array()
		   $sess_array = array(
			 //'id' => $row->id,
			 'username' => $row->username
		   );
		   $this->session->set_userdata('logged_in', $sess_array);
		 }
		$this->session->set_userdata('logged_in', $sess_array);
		
		$session_data = $this->session->userdata('logged_in');
     	$data['username'] = $session_data['username'];
		echo $session_data['username'];*/
	}
}
?>