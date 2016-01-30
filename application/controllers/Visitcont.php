<?php
class Visitcont extends CI_Controller 
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
		$_SESSION['update'] = $patientFileId;
		
	}
	function newvisitdata()
	{
		extract($_POST);
		$_SESSION['patientFileId'] = $patientFileId;
		
	}
	/******************* USER FORM *****************************/
	function visitform()
	{
		$this->load->model('constantmodel');
		$this->data['visittype']= $this->constantmodel->get_sub_constant(40);
		$this->data['plantype']= $this->constantmodel->get_sub_constant(2);
		
		
		if(isset($_SESSION['update']))
			{
				$this->load->model('visitmodel');
				$this->data['visit_info'] = $this->visitmodel->get_patient_by_id($_SESSION['patientFileId']);
			}
		
	}
	/***********************************************************/
	function visits()
	{
		$this->load->model('constantmodel');
	//	$this->data['status']          = $this->constantmodel->get_sub_constant(2);
		//$this->data['governorate']     = $this->constantmodel->get_sub_constant(22);
		$this->data['visittype']          = $this->constantmodel->get_sub_constant(2);
		
		
	}
	/******************* ADD USER ******************************/
	function addvisit()
	{
		$this->load->model('visitmodel');
		$output=$this->visitmodel->insert_visit();
		header('Access-Control-Allow-Origin: *');
		header("Content-Type: application/json");
		echo json_encode($output);
		
	}
	
	
	/******************* Update visit ******************************/
	function updatevisit()
	{
		$this->load->model('visitmodel');
		$this->visitmodel->update_visit();
	}
	/************************************************************/
	
	/******************* USER DATA GRID *************************/
	function visit()
	{
		$this->load->model('constantmodel');

		
	}
	function visitsgriddata()
	{
		$this->load->model('visitmodel');
		$rec = $this->visitmodel->get_search_visit($_REQUEST);
		
		
		$i = 1;
		$data = array();
		foreach($rec as $row)
		{
			$nestedData=array();
			/*
			if ($row->active_account == 1)
				$active = '<i class="fa fa-user font-green"></i>';
			else
				$active = '<i class="fa fa-user font-red-sunglo"></i>';
				*/
			/*$btn='<a href="'.base_url().'adduser/'.$row->user_name.'" class="btn default btn-xs purple">
			  <i class="fa fa-edit"></i> تعديل </a>';*/
			
			$btn='<a class="btn default btn-xs purple" onclick="gotoVisit(\''.$row->outpatient_visit_id.'\')">
			  <i class="fa fa-edit"></i> تعديل </a>';
			
			$nestedData[] = $i++;
			$nestedData[] = $row->patient_file_id;
			$nestedData[] = $row->patient_id;
			$nestedData[] = $row->name;
			$nestedData[] = $row->phone;
			$nestedData[] = $row->mobile;
			$nestedData[] = $row->Patient_governorate;
			$nestedData[] = $row->visit_date;
			$nestedData[] = $row->visit_type_desc;
			//$nestedData[] = $active;
			$nestedData[] = $btn;
			
			$data[] = $nestedData;
		} // End Foreach
		
		$totalFiltered = count($rec);
		$totalData=$this->visitmodel->count_visits();
		
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