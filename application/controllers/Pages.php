<?php
class Pages extends CI_Controller 
{
	public $data;
	
	function view ( $page = 'home')
	{
		if( ! file_exists('application/views/pages/'.$page.'.php'))
		{
			show_404();
		}
		
		if ($page == 'login')
		{
			$data['title'] = $page;
			$this->load->view('templates/header',$data);
			$this->load->view('pages/'.$page,$data);
		}
		else if($this->session->userdata('logged_in'))
		{
			$this->data['title'] = $page;
			//$this->$page();
			
			$this->load->view('templates/header',$this->data);
			$this->load->view('templates/nav');
			$this->load->view('templates/sidebar');
			$this->load->view('templates/stylecustomizer');
			$this->load->view('templates/pageheader');
			$this->load->view('pages/'.$page,$this->data);
			$this->load->view('templates/quicksidebar.php');
			$this->load->view('templates/footer');
		}
		else
   		{
     		//If no session, redirect to login page
     		redirect('login', 'refresh');
   		}
		
	}
	function home()
	{
		
		
	}
	/*******************EMPLOYEE*******************************/
	function employee()
	{
		$this->load->model('constantmodel');
		$this->data['job_title'] = $this->constantmodel->get_sub_constant(1);
		$this->data['is_active'] = $this->constantmodel->get_sub_constant(1);
		
	}
	/*******************EMPLOYEE*******************************/
	function logout()
	{
		$this->session->unset_userdata('logged_in');
   		session_destroy();
   		redirect('login', 'refresh');
	}
}
?>