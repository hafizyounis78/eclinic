<?php
class Patientcont extends CI_Controller 
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
	/******************* USER FORM *****************************/
	function patientform()
	{
		$this->load->model('constantmodel');
		$this->data['status']          = $this->constantmodel->get_sub_constant(2);
		$this->data['governorate']     = $this->constantmodel->get_sub_constant(22);
		
		if(isset($_SESSION['update']))
		{
			$this->load->model('patientmodel');
			$this->data['patient_info'] = $this->patientmodel->get_patient_by_id($_SESSION['update']);
			foreach ($this->data['patient_info'] as $row);
				{	
					$this->data['region']     = $this->constantmodel->get_region_list($row->governorate_id);
					$this->data['fulladdress']     = $this->constantmodel->get_region_list($row->region_id);
				}
			
		}
		unset($_SESSION['update']);
	}
	/***********************************************************/
	function patient()
	{
		$this->load->model('constantmodel');
		$this->data['status']          = $this->constantmodel->get_sub_constant(2);
		$this->data['governorate']     = $this->constantmodel->get_sub_constant(22);
		
		
	}
	
	function patientlist()
	{
		$this->load->model('constantmodel');
		$this->data['visitType']     = $this->constantmodel->get_sub_constant(75);
		$this->data['visitStatus']          = $this->constantmodel->get_sub_constant(76);

		
		
	}
	/******************* ADD USER ******************************/
	function addpatient()
	{
		$this->load->model('patientmodel');
		$output=$this->patientmodel->insert_patient();
		
		header('Access-Control-Allow-Origin: *');
		header("Content-Type: application/json");
		echo json_encode($output);
		
	}
	
	/************************************************************/
	function check_id()
	{
		$this->load->model('patientmodel');
		$rec=$this->patientmodel->check_patient_id();
		
		
		foreach($rec->result() as $row)
		{
  			echo $row->cn;
		}
	}
	/******************* Update USER ******************************/
	function updatepatient()
	{
		$this->load->model('patientmodel');
		$this->patientmodel->update_patient();
	}
	/************************************************************/
	
	/******************* USER DATA GRID *************************/
	/*function patients()
	{
		$this->load->model('constantmodel');

		
	}*/
	function patientsgriddata()
	{
		$this->load->model('patientmodel');
		$rec = $this->patientmodel->get_search_patient($_REQUEST);
		
		
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
			
			$btn='<a class="btn default btn-xs purple" onclick="gotoPatient(\''.$row->patient_file_id.'\')">
			  <i class="fa fa-edit"></i> تعديل </a>
			  <a class="btn default btn-xs purple" onclick="gotoPatientVisit('.'0'.','.$row->patient_file_id.')">
			  <i class="fa fa-edit"></i> زيارة جديدة </a>';
			
			$nestedData[] = $i++;
			$nestedData[] = $row->patient_file_id;
			$nestedData[] = $row->patient_id;
			$nestedData[] = $row->name;
			$nestedData[] = $row->phone;
			$nestedData[] = $row->mobile;
			$nestedData[] = $row->Patient_governorate;
//			$nestedData[] = $row->last_visit;
			//$nestedData[] = $active;
			$nestedData[] = $btn;
			
			$data[] = $nestedData;
		} // End Foreach
		
		$totalFiltered = count($rec);
		$totalData=$this->patientmodel->count_patients();
		
		//$records["draw"] = $sEcho;
		$json_data = array(
					"draw"            => intval( $_REQUEST['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
					"recordsTotal"    => intval( $totalData ),  // total number of records
					"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
					"data"            => $data   // total data array
					);
		
		echo json_encode($json_data);  // send data as json format
	}
	
	function patientsListgriddata()
	{
		$this->load->model('patientmodel');
		$rec = $this->patientmodel->get_patient_list($_REQUEST);
		
		
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
			
			$btn='<a class="btn default btn-xs purple" onclick="gotoPatientVisit('.$row->outpatient_visit_id.','.$row->patient_file_id.')">
			  <i class="fa fa-edit"></i> متابعة المريض </a>';
			
			$nestedData[] = $i++;
			$nestedData[] = $row->patient_file_id;
			$nestedData[] = $row->name;
			$nestedData[] = $row->visit_date;
			$nestedData[] = $row->visitType;
			$nestedData[] = $row->visitStatus;
			
			
			$nestedData[] = $btn;
			
			$data[] = $nestedData;
		} // End Foreach
		
		$totalFiltered = count($rec);
		$totalData=$this->patientmodel->count_patientsList();
		
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
	
	function get_region()
	{
		$this->load->model('patientmodel');
		$rec=$this->patientmodel->get_region_list();
		$SurveyId=0;
		if (count($rec) == 0)
		{
			echo 0;
			return;
		}
		$output = array();
		foreach($rec as $row)
		{
			unset($temp); // Release the contained value of the variable from the last loop
			$temp = array();

			// It guess your client side will need the id to extract, and distinguish the ScoreCH data
		
		$temp['sub_constant_id'] = $row->sub_constant_id;
		$temp['sub_constant_name'] = $row->sub_constant_name ;
		
			array_push($output,$temp);
			
			
			
		}
		header('Access-Control-Allow-Origin: *');
			header("Content-Type: application/json");
			echo json_encode($output);
}
function get_fulladdress()
	{
		$this->load->model('patientmodel');
		$rec=$this->patientmodel->get_fulladress_list();
		$SurveyId=0;
		if (count($rec) == 0)
		{
			echo 0;
			return;
		}
		$output = array();
		foreach($rec as $row)
		{
			unset($temp); // Release the contained value of the variable from the last loop
			$temp = array();

			// It guess your client side will need the id to extract, and distinguish the ScoreCH data
		
		$temp['sub_constant_id'] = $row->sub_constant_id;
		$temp['sub_constant_name'] = $row->sub_constant_name ;
		
			array_push($output,$temp);
			
			
			
		}
		header('Access-Control-Allow-Origin: *');
			header("Content-Type: application/json");
			echo json_encode($output);
}		
}
?>