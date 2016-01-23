<?php
class Employee extends CI_Controller 
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
			$this->$page();
			
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
	
	/********************/
	function senddata()
	{
		extract($_POST);
		$_SESSION['update'] = $national_id;
		//echo $_SESSION['update'];
		//$this->empform();
		//exit;
	}
	/******************* USER FORM *****************************/
	function empform()
	{
		$this->load->model('constantmodel');
		$this->data['job_title'] = $this->constantmodel->get_sub_constant(3);
		
		if(isset($_SESSION['update']))
		{
			$this->load->model('employeemodel');
			$this->data['employee_info'] = $this->employeemodel->get_employee_info($_SESSION['update']);
			
		}
	}
	/***********************************************************/
	
	/******************* ADD USER ******************************/
	function addemployee()
	{
		$this->load->model('employeemodel');
		$this->employeemodel->insert_employee();
	}
	
	/************************************************************/
	function check_id()
	{
		$this->load->model('employeemodel');
		$rec=$this->employeemodel->check_employee_id();
		
		foreach($rec->result() as $row)
		{
  			echo $row->cn;
		}
	}
	/******************* Update USER ******************************/
	function updateemployee()
	{
		$this->load->model('employeemodel');
		$this->employeemodel->update_employee();
	}
	/************************************************************/
	
	/******************* USER DATA GRID *************************/
	function employees()
	{
		$this->load->model('constantmodel');

		$this->data['emp_job_title'] = $this->constantmodel->get_sub_constant(3);
	}
	function employeegriddata()
	{
		$this->load->model('employeemodel');
		$rec = $this->employeemodel->get_search_employee($_REQUEST);
		
		
		$i = 1;
		$data = array();
		foreach($rec as $row)
		{
			$nestedData=array();
			
			if ($row->active_account == 1)
				$active = '<i class="fa fa-user font-green"></i>';
			else
				$active = '<i class="fa fa-user font-red-sunglo"></i>';
				
			/*$btn='<a href="'.base_url().'adduser/'.$row->user_name.'" class="btn default btn-xs purple">
			  <i class="fa fa-edit"></i> تعديل </a>';*/
			
			$btn='<a class="btn default btn-xs purple" onclick="gotoEmployee(\''.$row->national_id.'\')">
			  <i class="fa fa-edit"></i> تعديل </a>';
			
			$nestedData[] = $i++;
			$nestedData[] = $row->national_id;
			$nestedData[] = $row->emp_id;
			$nestedData[] = $row->name;
			$nestedData[] = $row->job_title;
			$nestedData[] = $row->mobile;
			$nestedData[] = $row->email;
			$nestedData[] = $active;
			$nestedData[] = $btn;
			
			$data[] = $nestedData;
		} // End Foreach
		
		$totalFiltered = count($rec);
		$totalData=$this->employeemodel->count_employee();
		
		//$records["draw"] = $sEcho;
		$json_data = array(
					"draw"            => intval( $_REQUEST['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
					"recordsTotal"    => intval( $totalData ),  // total number of records
					"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
					"data"            => $data   // total data array
					);
		
		echo json_encode($json_data);  // send data as json format
	}
	/************************************************************/
	
	
}
?>