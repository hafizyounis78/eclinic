<?php
class Surveyupdatecont extends CI_Controller 
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
	
	function senddata()
	{
		extract($_POST);
		$_SESSION['update'] = $SurveyId;
		$_SESSION['elder_id']=$elderId;
	}
	
	//************************************Get survey Data to update*******************//
	function surveyupdate()
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
		$this->data['survey_ElderDisease'] = $this->constantmodel->get_sub_constant(54);
		$this->data['survey_ElderBehaviour'] = $this->constantmodel->get_sub_constant(43);
		$this->data['survey_Hometype'] = $this->constantmodel->get_sub_constant(55);
		$this->data['survey_ElderPariah'] = $this->constantmodel->get_sub_constant(56);
		$this->data['survey_Organization'] = $this->constantmodel->get_sub_constant(57);
		$this->data['survey_Hiring'] = $this->constantmodel->get_sub_constant(69);
		

		$this->load->model('Employeemodel');
		$this->data['survey_employee_info'] = $this->Employeemodel->get_all_employee();
		$this->data['survey_id'] = $_SESSION['update'];
		
		if(isset($_SESSION['update']))
		{
			$this->load->model('Surveyviewmodel');
			$this->data['elder_info'] = $this->Surveyviewmodel->get_elder_info($_SESSION['elder_id']);
			foreach ($this->data['elder_info'] as $row);
			{	
				$this->data['region']     = $this->constantmodel->get_region_list($row->governorate_id);
				$this->data['fulladdress']     = $this->constantmodel->get_region_list($row->region);
			}
			
			$this->data['survey_info'] = $this->Surveyviewmodel->get_survey_info($_SESSION['update']);
			$this->data['homeStatus_info'] = $this->Surveyviewmodel->get_homeStatus_info($_SESSION['update']);
			$this->data['elderRoom_info'] = $this->Surveyviewmodel->get_elderRoom_info($_SESSION['update']);
//			$this->data['elderFamilyRelation_info'] = $this->Surveyviewmodel->get_elderFamilyRelation_info($_SESSION['update']);
			$this->data['lifeImprovement_info'] = $this->Surveyviewmodel->get_lifeImprovement_info($_SESSION['update']);
			
			$this->data['medicationNeed_info'] = $this->Surveyviewmodel->get_medicationNeed_info($_SESSION['update']);
			$this->data['medicationAvailability_info'] = $this->Surveyviewmodel->get_medicationAvailability_info($_SESSION['update']);
			$this->data['medicalAidRecomend_info'] = $this->Surveyviewmodel->get_medicalAidRecomend_info($_SESSION['update']);
			$this->data['incomeResources_info'] = $this->Surveyviewmodel->get_incomeResources_info($_SESSION['update']);
			//foreach($this->data['incomeResources_info'] as $row)
			$this->data['incomeResourcesDetails_info'] = $this->Surveyviewmodel->get_incomeResourcesDetails_info($_SESSION['update']);
			
			$this->data['homeImprovRecomend_info'] = $this->Surveyviewmodel->get_homeImprovRecomend_info($_SESSION['update']);
			$this->data['followUp_info'] = $this->Surveyviewmodel->get_followUp_info($_SESSION['elder_id']);
			
			$this->data['familyMember_info'] = $this->Surveyviewmodel->get_familyMember_info($_SESSION['elder_id']);
			$this->data['familyRelationship_info'] = $this->Surveyviewmodel->get_familyRelationship_info($_SESSION['update']);
			$this->data['familyCooperation_info'] = $this->Surveyviewmodel->get_familyCooperation_info($_SESSION['update']);
			$this->data['elderPariah_info'] = $this->Surveyviewmodel->get_elderPariah_info($_SESSION['update']);
			$this->data['familyPsyStatus_info'] = $this->Surveyviewmodel->get_familyPsyStatus_info($_SESSION['update']);
			
			$this->data['elderInteresting_info'] = $this->Surveyviewmodel->get_elderInteresting_info($_SESSION['update']);
			//$this->data['elderDoc_info'] = $this->Surveyviewmodel->get_elderDoc_info($_SESSION['update']);
			$this->data['elderDisease_info'] = $this->Surveyviewmodel->get_elderDisease_info($_SESSION['update']);
			
		/*	foreach($this->data['elderDisease_info'] as $row)
			*/
			$this->data['elderDiseaseDet_info'] = $this->Surveyviewmodel->get_elderDiseaseDet_info($_SESSION['update']);
	
			$this->data['elderBehaviour_info'] = $this->Surveyviewmodel->get_elderBehaviour_info($_SESSION['update']);
			$this->data['aidsRecomendation_info'] = $this->Surveyviewmodel->get_aidsRecomendation_info($_SESSION['update']);
																					
		}
		
	}
	
}
?>