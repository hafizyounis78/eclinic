<?php
class Surveyviewcont extends CI_Controller 
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
	//************************************Get survey Data to update*******************//
	function survey()
	{
		$this->load->model('constantmodel');
		$this->data['survey_Filestatus'] = $this->constantmodel->get_sub_constant(51);
		$this->data['survey_Eldercategory'] = $this->constantmodel->get_sub_constant(53);
		$this->data['survey_Maritalstatus'] = $this->constantmodel->get_sub_constant(2);
		$this->data['survey_Governorate'] = $this->constantmodel->get_sub_constant(22);
		$this->data['survey_Specialization'] = $this->constantmodel->get_sub_constant(24);
		$this->data['survey_Educationlevel'] = $this->constantmodel->get_sub_constant(23);
		$this->data['survey_CurrentJob'] = $this->constantmodel->get_sub_constant(25);
		$this->data['survey_PreviousJob'] = $this->constantmodel->get_sub_constant(26);
		$this->data['survey_InsuranceType'] = $this->constantmodel->get_sub_constant(7);
		$this->data['survey_Relationship'] = $this->constantmodel->get_sub_constant(4);
		$this->data['survey_Health'] = $this->constantmodel->get_sub_constant(28);
		$this->data['survey_IncomeSource'] = $this->constantmodel->get_sub_constant(29);
		$this->data['survey_HomeStatus'] = $this->constantmodel->get_sub_constant(30);
		$this->data['survey_HomeType'] = $this->constantmodel->get_sub_constant(31);
		$this->data['survey_CeilingType'] = $this->constantmodel->get_sub_constant(32);
		$this->data['survey_FurnitureLevel'] = $this->constantmodel->get_sub_constant(33);
		$this->data['survey_Roomtype'] = $this->constantmodel->get_sub_constant(34);
		$this->data['survey_Clothes'] = $this->constantmodel->get_sub_constant(35);
		$this->data['survey_Ventilation'] = $this->constantmodel->get_sub_constant(36);
		$this->data['survey_Lighting'] = $this->constantmodel->get_sub_constant(37);
		$this->data['survey_Choice'] = $this->constantmodel->get_sub_constant(38);
		$this->data['survey_Bathroom'] = $this->constantmodel->get_sub_constant(39);
		$this->data['survey_Higiene'] = $this->constantmodel->get_sub_constant(40);
		$this->data['survey_MedicationNeed'] = $this->constantmodel->get_sub_constant(41);
		$this->data['survey_MedicationType'] = $this->constantmodel->get_sub_constant(42);
		$this->data['survey_PsychologicalStatus'] = $this->constantmodel->get_sub_constant(44);
		$this->data['survey_ElderWorkAbility'] = $this->constantmodel->get_sub_constant(45);
		$this->data['survey_FamilyMember'] = $this->constantmodel->get_sub_constant(46);
		$this->data['survey_CashAidType'] = $this->constantmodel->get_sub_constant(47);
		$this->data['survey_NutritionType'] = $this->constantmodel->get_sub_constant(48);
		$this->data['survey_PsychologicalSupport'] = $this->constantmodel->get_sub_constant(49);
		$this->data['survey_HomeImprovRecomend'] = $this->constantmodel->get_sub_constant(50);

		$this->load->model('Employeemodel');
		$this->data['survey_employee_info'] = $this->Employeemodel->get_all_employee();
		
		if(isset($_SESSION['update']))
		{
			$this->load->model('Surveyviewmodel');
			$this->data['survey_info'] = $this->Surveyviewmodel->get_survey_info($_SESSION['update']);
			$this->data['homeStatus_info'] = $this->Surveyviewmodel->get_homeStatus_info($_SESSION['update']);
			$this->data['elderRoom_info'] = $this->Surveyviewmodel->get_elderRoom_info($_SESSION['update']);
			$this->data['elderFamilyRelation_info'] = $this->Surveyviewmodel->get_elderFamilyRelation_info($_SESSION['update']);
			$this->data['lifeImprovement_info'] = $this->Surveyviewmodel->get_lifeImprovement_info($_SESSION['update']);
			
		}
		
	}
	
	function viewsurvey()
	{
		$this->load->model('constantmodel');

		$this->data['emp_job_title'] = $this->constantmodel->get_sub_constant(3);
	}
	//******************************************Ajax Table***************************//
	function surveygriddata()
	{
		$this->load->model('Surveyviewmodel');
		$totalData=$this->Surveyviewmodel->count_get_search_survey();
		$rec = $this->Surveyviewmodel->get_search_survey($_REQUEST);
		$totalFiltered = count($rec);
		
		$allowSurveyupdate = false;
		$allowFolloupinsert = false;
		$res_menue = $this->session->userdata('menue');
		foreach($res_menue as $row)
		{
			if($row->page_id == 26)
				$allowSurveyupdate = true;
			if($row->page_id == 27)
				$allowFolloupinsert = true;
		}
		
		$i = 1;
		$data = array();
		foreach($rec as $row)
		{
			$btn='';
			$nestedData=array();
			
			if ($allowSurveyupdate)
			  $btn='<a class="btn default btn-xs purple" onclick="gotoSurveyUpdate('.$row->survey_id.','.$row->elder_id.')">
				<i class="fa fa-edit"></i>تعديل الاستبانة </a>';
			if ($allowFolloupinsert)
			  $btn=$btn.'<a class="btn default btn-xs purple" onclick="gotoFollowup(\''.$row->elder_id.'\')">
				<i class="fa fa-edit"></i> ملف المتابعة </a>';
			
			/*$btn='<a class="btn default btn-xs purple" onclick="gotoFollowup(\''.$row->elder_id.'\')">
			  <i class="fa fa-edit"></i> ملف المتابعة </a>';*/
			
			$nestedData[] = $i++;
			$nestedData[] = $row->Researcher_name;
			$nestedData[] = $row->Elder_name;
			$nestedData[] = $row->visit_date;
			$nestedData[] = $btn;
			
			$data[] = $nestedData;
		} // End Foreach
		
		
		//$totalData = 1;
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
function senddata()
	{
		extract($_POST);
		$_SESSION['update'] = $survey_id;
	}
?>