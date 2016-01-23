<?php
class Surveycont extends CI_Controller 
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
		$this->data['survey_Hometype'] = $this->constantmodel->get_sub_constant(55);
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
		$this->data['survey_ElderPariah'] = $this->constantmodel->get_sub_constant(56);
		$this->data['survey_Organization'] = $this->constantmodel->get_sub_constant(57);
		$this->data['survey_Hiring'] = $this->constantmodel->get_sub_constant(69);
		
		
		$this->load->model('Employeemodel');
		$this->data['survey_employee_info'] = $this->Employeemodel->get_all_employee();
		
	}
	
/************************* ELDER TAB ************************/
	
	function addelder()
	{
		$this->load->model('Surveymodel');
		$output = $this->Surveymodel->insert_elder();
		
		header('Access-Control-Allow-Origin: *');
		header("Content-Type: application/json");
		echo json_encode($output);
	}
	
	function updateelder()
	{
		$this->load->model('Surveymodel');
		$output = $this->Surveymodel->update_elder();
		
		header('Access-Control-Allow-Origin: *');
		header("Content-Type: application/json");
		echo json_encode($output);
	}
	
	// check elder id 
	function check_elder_id()
	{
		$this->load->model('Eldermodel');
		$rec=$this->Eldermodel->get_elder_by_id();
		
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
			$temp['hdnFileId']   		= $row->file_id;
			$temp['FileStatus']  		= $row->file_status_id;
			$temp['drpEldercategory']  	= $row->elder_category_id;
			$temp['txtFname'] 	 		= $row->first_name;
			$temp['txtMname'] 	 		= $row->middle_name;
			$temp['txtThname'] 	 		= $row->third_name;
			$temp['txtLname'] 	 		= $row->last_name;
			$temp['dpDob'] 		 		= $row->dob;
			$temp['rdSex'] 		 		= $row->sex_id;
			$temp['drpElderstatus'] 	= $row->status_id;
			$temp['drpGovernorate'] 	= $row->governorate_id;
			$temp['drpRegion'] 			= $row->region;
			$temp['drpFulladdress'] 	= $row->full_address;
			$temp['txtPhone'] 			= $row->phone;
			$temp['txtMobile1'] 		= $row->mobile_first;
			$temp['txtMobile2'] 		= $row->mobile_second;
			$temp['drpEducationlevel'] 	= $row->education_level_id;
			$temp['drpSpecialization'] 	= $row->specialization_id;
			$temp['drpCurrentjob'] 		= $row->current_job_id;
			$temp['drpPreviousjob'] 	= $row->previous_job_id;
			$temp['drpInsurence'] 		= $row->insurance_type_id;
			$temp['DeathDate'] 			= $row->death_date;
			array_push($output,$temp);
			
			
			header('Access-Control-Allow-Origin: *');
			header("Content-Type: application/json");
			echo json_encode($output);
		}
	
	
		
		
	}
/*********************** END ELDER TAB ************************/
/************************* VISIT TAB **************************/

	function updatesurvey()
	{
		$this->load->model('Surveymodel');
		$this->Surveymodel->update_survey();
	}
	
//******************* FAMILY MEMBER TAB ************************/

	function addfamilymember()
	{
		$this->load->model('Surveymodel');
		$this->Surveymodel->insert_familyMember();
		
		extract($_POST);
		
		$rec = $this->Surveymodel->get_familyMember_by_survey_id($hdnSurveyId);
		
		$i=1;
		foreach($rec as $row)
		{
			
			echo "<tr>";
			echo "<td>" . $i++ . "</td>";
			echo "<td>" . $row->member_name . "</td>";
			echo "<td>" . $row->member_id . "</td>";
			echo "<td>" . $row->sex . "</td>";
			echo "<td>" . $row->relationship ."</td>";
			echo "<td>" . $row->fmstatus ."</td>";
			echo "<td>" . $row->dob . "</td>";
			echo "<td>" . $row->education_level . "</td>";
			echo "<td>" . $row->health_status . "</td>";
			echo "<td>" . $row->job . "</td>";
			echo "<td>" . $row->income_shekel . "</td>";
			echo '<td><button id="btnDeletedoc" name="btnDeletedoc" type="button" 
                              class="btn btn-circle red-sunglo btn-sm" 
                              onclick="deleteFamilymember('. $row->family_member_id .')">
                               <i id="iConst" class="fa fa-close"></i>
                      </button></td>';
			echo "</tr>";
			
			
			
		}
		
		
	}
	function updatefamilymember()
	{
		$this->load->model('Surveymodel');
		$this->Surveymodel->update_familyMember();
	}
	function deletefamilymember()
	{
		$this->load->model('Surveymodel');
		$this->Surveymodel->delete_familyMember();
		
		extract($_POST);
		
		$rec = $this->Surveymodel->get_familyMember_by_survey_id($hdnSurveyId);
		
		$i=1;
		foreach($rec as $row)
		{
			
			echo "<tr>";
			echo "<td>" . $i++ . "</td>";
			echo "<td>" . $row->member_name . "</td>";
			echo "<td>" . $row->member_id . "</td>";
			echo "<td>" . $row->sex . "</td>";
			echo "<td>" . $row->relationship ."</td>";
			echo "<td>" . $row->fmstatus ."</td>";
			echo "<td>" . $row->dob . "</td>";
			echo "<td>" . $row->education_level . "</td>";
			echo "<td>" . $row->health_status . "</td>";
			echo "<td>" . $row->job . "</td>";
			echo "<td>" . $row->income_shekel . "</td>";
			echo '<td><button id="btnDeletedoc" name="btnDeletedoc" type="button" 
                              class="btn btn-circle red-sunglo btn-sm" 
                              onclick="deleteFamilymember('. $row->family_member_id .')">
                               <i id="iConst" class="fa fa-close"></i>
                      </button></td>';
			echo "</tr>";
			
			
			
		}
	}
//******************* END FAMILY MEMBER TAB ************************/

/************************ Health Status TAB ************************/
	function adddisease()
	{
		
		$this->load->model('Surveymodel');
		$elder_disease_id = $this->Surveymodel->elder_disease_det_insert();
		
		extract($_POST);
		
		$rec = $this->Surveymodel->get_elder_disease_by_survey_id($hdnSurveyId);
		
		echo $elder_disease_id.'|';
		foreach($rec as $row)
		{
			
			echo '<tr>';
			echo '<td>';
			echo '<div class="col-md-11">';
			echo '<span class="font-blue">' . $row->disease .'</span></div>';
			echo '<div class="col-md-1"><button id="btnDeletedoc" name="btnDeletedoc" type="button" 
								  class="btn btn-circle red-sunglo btn-sm" 
								  onclick="delete_elder_disease('. $row->elder_disease_det_id .','. $row->disease_id .')">
								   <i id="iConst" class="fa fa-close"></i>
						  </div>';
			echo "</td>";
			echo "</tr>";
		}
		
	}
	
	function deletedisease()
	{
		$this->load->model('Surveymodel');
		$this->Surveymodel->elder_disease_det_delete();
		
		extract($_POST);
		
		$rec = $this->Surveymodel->get_elder_disease_by_survey_id($hdnSurveyId);
		
		foreach($rec as $row)
		{
			
			echo '<tr>';
			echo '<td>';
			echo '<div class="col-md-11">';
			echo '<span class="font-blue">' . $row->disease .'</span></div>';
			echo '<div class="col-md-1"><button id="btnDeletedoc" name="btnDeletedoc" type="button" 
								  class="btn btn-circle red-sunglo btn-sm" 
								  onclick="delete_elder_disease('. $row->elder_disease_det_id .','. $row->disease_id .')">
								   <i id="iConst" class="fa fa-close"></i></button>
						  </div>';
			echo "</td>";
			echo "</tr>";
		}
	}
	
	function adddiseasedet()
	{
		$this->load->model('Surveymodel');
		
		extract($_POST);
		
		if ($hdnElderDiseaseId == '')
			$hdnElderDiseaseId = $this->Surveymodel->elder_disease_insert();
		else
			$this->Surveymodel->elder_disease_update();
		
		echo $hdnElderDiseaseId;
				
	}
	
/************************ END Health Status TAB ************************/

/************************* Income Resources TAB ************************/
	function addincomeresourcedet()
	{
		$this->load->model('Surveymodel');
		$IncomeResourcesId = $this->Surveymodel->income_resources_details_insert();
		
		$this->drowincometable();
		
	}
	function deleteincomeresourcedet()
	{
		$this->load->model('Surveymodel');
		$this->Surveymodel->income_resources_details_delete();
		
		$this->drowincometable();
		
	}
	function addincomeresource()
	{
		$this->load->model('Surveymodel');
		$res = $this->Surveymodel->income_resources_insert();
		
		echo $res;
		
	}
	function updateincomeresource()
	{
		$this->load->model('Surveymodel');
		$this->Surveymodel->income_resources_update();
		
		extract($_POST);
		
		echo $hdnIncomeResourcesId;
		
	}
	function drowincometable()
	{
		extract($_POST);
		
		$rec = $this->Surveymodel->get_income_resources_details($hdnSurveyId);
		$i=1;
		$j=1;
		$org_row = "";
		$total_cash = 0;
		$total_package = 0;
		foreach($rec as $row)
		{
			$total_cash = $total_cash + $row->cash_income;
			$total_package = $total_package + $row->package_cash_value;
			
			if($row->resource_id == 75)
			{
				if ($j == 1)
				{
					$org = $row->resource;
				}
				$org_row = $org_row . '<tr><td>' . $j++ . '- ' . $row->organization . '</td>'
									. '<td>' . $row->cash_income . '</td>'
									. '<td>' . $row->package_income . '</td>'
									. '<td>' . $row->package_cash_value . '</td>'
									. '<td><div class="col-md-1"><button id="btnDeletedoc" name="btnDeletedoc" type="button" 
										  class="btn btn-circle red-sunglo btn-sm" 
										  onclick="delete_income_resource_det('. $row->income_resources_details_id .','
																			   . $row->resource_id .',\''
																			   . $row->organization_id .'\')">
										   <i id="iConst" class="fa fa-close"></i></button>
								  		 </div>
								  </td></tr>';
		
			}
			else
			{
				echo '<tr>';
				echo '<td>' . $i++ . '</td>';
				echo '<td>' . $row->resource . '</td>';
				echo '<td>' . $row->cash_income . '</td>';
				echo '<td>' . $row->package_income . '</td>';
				echo '<td>' . $row->package_cash_value . '</td>';
				echo '<td><div class="col-md-1"><button id="btnDeletedoc" name="btnDeletedoc" type="button" 
									  class="btn btn-circle red-sunglo btn-sm" 
									  onclick="delete_income_resource_det('. $row->income_resources_details_id .','
																		   . $row->resource_id .',\''
																		   . $row->organization_id .'\')">
									   <i id="iConst" class="fa fa-close"></i></button>
							  </div>';
				echo "</td>";
				echo "</tr>";
			}
			
		}
		
		if ($j > 1)
		{
			echo '<tr>';
			echo '<td rowspan="' .$j. '">' . $i++ . '</td>';
			echo '<td> ' . $org . ' </td>';
			echo '<td> &nbsp; </td>';
			echo '<td> &nbsp; </td>';
			echo '<td> &nbsp; </td>';
			echo '<td> &nbsp; </td>';
			echo "</tr>";
			echo $org_row;
		}
		
		// Total Row
		echo '<tr class="bg-grey-steel">';
		echo '<td> &nbsp; </td>';
		echo '<td> المــجـموع الكـلي </td>';
		echo '<td> '.$total_cash.' </td>';
		echo '<td> &nbsp; </td>';
		echo '<td> '.$total_package.' </td>';
		echo '<td> &nbsp; </td>';
		echo "</tr>";
	}
/*********************** END Income Resources TAB **********************/

/************************ Family Home Status TAB ***********************/

	function addhomeStatus()
	{
		$this->load->model('Surveymodel');
		$res = $this->Surveymodel->insert_homeStatus();
		
		echo $res;
		
	}
	function updatehomeStatus()
	{
		$this->load->model('Surveymodel');
		$this->Surveymodel->update_homeStatus();
		
		extract($_POST);
		echo $hdnHomeStatusId;
	}

/********************** END Family Home Status TAB *********************/

/**************************** Elder Room TAB ***************************/

	function addelderRoom()
	{
		$this->load->model('Surveymodel');
		$res = $this->Surveymodel->insert_elderRoom();
		
		echo $res;
		
	}
	function updateelderRoom()
	{
		$this->load->model('Surveymodel');
		$this->Surveymodel->update_elderRoom();
		
		extract($_POST);
		echo $hdnElderRoomId;
		
	}

/************************* END Elder Room TAB **************************/
/*************************** Medication TAB ****************************/
	function addmedicationavailabl()
	{
		$this->load->model('Surveymodel');
		$this->Surveymodel->medication_availability_insert();
		
		extract($_POST);
		
		$rec = $this->Surveymodel->get_medication_availability($hdnSurveyId);
		
		foreach($rec as $row)
		{
			
			echo '<tr>';
			echo '<td>'. $row->medicine_name .'</td>';
			echo '<td>'. $row->availability_status .'</td>';
			echo '<td>'. $row->unavailable_reason .'</td>';
			echo '<td><button id="btnDeletedoc" name="btnDeletedoc" type="button" 
							  class="btn btn-circle red-sunglo btn-sm" 
							  onclick="delete_medication_availability('. $row->medication_availability_id .')">
							   <i id="iConst" class="fa fa-close"></i></button>';
			echo "</td>";
			echo "</tr>";
		}
	}
	function deletemedicationavailabl()
	{
		$this->load->model('Surveymodel');
		$this->Surveymodel->medication_availability_delete();
		
		extract($_POST);
		
		$rec = $this->Surveymodel->get_medication_availability($hdnSurveyId);
		
		foreach($rec as $row)
		{
			
			echo '<tr>';
			echo '<td>'. $row->medicine_name .'</td>';
			echo '<td>'. $row->availability_status .'</td>';
			echo '<td>'. $row->unavailable_reason .'</td>';
			echo '<td><button id="btnDeleteMedicavail" name="btnDeleteMedicavail" type="button" 
							  class="btn btn-circle red-sunglo btn-sm" 
							  onclick="delete_medication_availability('. $row->medication_availability_id .')">
							   <i id="iConst" class="fa fa-close"></i></button>';
			echo "</td>";
			echo "</tr>";
		}
	}
	function addmedicationneed()
	{
		$this->load->model('Surveymodel');
		$this->Surveymodel->medication_need_insert();
		
		extract($_POST);
		
		$rec = $this->Surveymodel->get_medication_need($hdnSurveyId);
		
		foreach($rec as $row)
		{
			
			echo '<tr>';
			echo '<td>'. $row->medication_type .'</td>';
			echo '<td>'. $row->medication_details .'</td>';
			echo '<td><button id="btnDeleteMedicneed" name="btnDeleteMedicneed" type="button" 
							  class="btn btn-circle red-sunglo btn-sm" 
							  onclick="delete_medication_need('. $row->medication_need_id  .
															  ','. $row->medication_type_id .')"">
							   <i id="iConst" class="fa fa-close"></i></button>';
			echo "</td>";
			echo "</tr>";
		}
	}
	function deletemedicationneed()
	{
		$this->load->model('Surveymodel');
		$this->Surveymodel->medication_need_delete();
		
		extract($_POST);
		
		$rec = $this->Surveymodel->get_medication_need($hdnSurveyId);
		
		foreach($rec as $row)
		{
			
			echo '<tr>';
			echo '<td>'. $row->medication_type .'</td>';
			echo '<td>'. $row->medication_details .'</td>';
			echo '<td><button id="btnDeleteMedicneed" name="btnDeleteMedicneed" type="button" 
							  class="btn btn-circle red-sunglo btn-sm" 
							  onclick="delete_medication_need('. $row->medication_need_id  .
															  ','. $row->medication_type_id .')"">
							   <i id="iConst" class="fa fa-close"></i></button>';
			echo "</td>";
			echo "</tr>";
		}
	}
/************************* END Medication TAB **************************/

/************************ Elder Behaviour TAB **************************/
	function addbehaviour()
	{
		$this->load->model('Surveymodel');
		$this->Surveymodel->elder_behaviour_insert();
		
		extract($_POST);
		
		$rec = $this->Surveymodel->get_elder_behaviour($hdnSurveyId);
		
		foreach($rec as $row)
		{
			
			echo '<tr>';
			echo '<td>';
			echo '<div class="col-md-11">';
			echo '<span class="font-blue">' . $row->behaviour .'</span></div>';
			echo '<div class="col-md-1"><button id="btnDeletedoc" name="btnDeletedoc" type="button" 
								  class="btn btn-circle red-sunglo btn-sm" 
								  onclick="delete_elder_behaviour('. $row->elder_behaviour_id .','
																 . $row->behaviour_id .')">
								   <i id="iConst" class="fa fa-close"></i>
						  </div>';
			echo "</td>";
			echo "</tr>";
		}
	}
	function deletebehaviour()
	{
		$this->load->model('Surveymodel');
		$this->Surveymodel->elder_behaviour_delete();
		
		extract($_POST);
		
		$rec = $this->Surveymodel->get_elder_behaviour($hdnSurveyId);
		
		foreach($rec as $row)
		{
			
			echo '<tr>';
			echo '<td>';
			echo '<div class="col-md-11">';
			echo '<span class="font-blue">' . $row->behaviour .'</span></div>';
			echo '<div class="col-md-1"><button id="btnDeletedoc" name="btnDeletedoc" type="button" 
								  class="btn btn-circle red-sunglo btn-sm" 
								  onclick="delete_elder_behaviour('. $row->elder_behaviour_id .','
																 . $row->behaviour_id .')">
								   <i id="iConst" class="fa fa-close"></i>
						  </div>';
			echo "</td>";
			echo "</tr>";
		}
		
	}
	function addpariah()
	{
		$this->load->model('Surveymodel');
		$this->Surveymodel->elder_pariah_insert();
		
		extract($_POST);
		
		$rec = $this->Surveymodel->get_elder_pariah($hdnSurveyId);
		
		foreach($rec as $row)
		{
			
			echo '<tr>';
			echo '<td>';
			echo '<div class="col-md-11">';
			echo '<span class="font-blue">' . $row->pariah_reason .'</span></div>';
			echo '<div class="col-md-1"><button id="btnDeletedoc" name="btnDeletedoc" type="button" 
								  class="btn btn-circle red-sunglo btn-sm" 
								  onclick="delete_elder_pariah('. $row->elder_pariah_id .','
																 . $row->elder_pariah_reason_id .')">
								   <i id="iConst" class="fa fa-close"></i>
						  </div>';
			echo "</td>";
			echo "</tr>";
		}
	}
	function deletepariah()
	{
		$this->load->model('Surveymodel');
		$this->Surveymodel->elder_pariah_delete();
		
		extract($_POST);
		
		$rec = $this->Surveymodel->get_elder_pariah($hdnSurveyId);
		
		foreach($rec as $row)
		{
			
			echo '<tr>';
			echo '<td>';
			echo '<div class="col-md-11">';
			echo '<span class="font-blue">' . $row->pariah_reason .'</span></div>';
			echo '<div class="col-md-1"><button id="btnDeletedoc" name="btnDeletedoc" type="button" 
								  class="btn btn-circle red-sunglo btn-sm" 
								  onclick="delete_elder_pariah('. $row->elder_pariah_id .','
																 . $row->elder_pariah_reason_id .')">
								   <i id="iConst" class="fa fa-close"></i>
						  </div>';
			echo "</td>";
			echo "</tr>";
		}
		
	}
/********************** END Elder Behaviour TAB ************************/
/******************* Family Elder Relationship TAB *********************/

	function addelderFamRel()
	{
		$this->load->model('Surveymodel');
		$this->Surveymodel->insert_elderFamilyRelation();
		
	}
	function updateelderFamRel()
	{
		$this->load->model('Surveymodel');
		$this->Surveymodel->update_elderFamilyRelation();
	}

/***************** END Family Elder Relationship TAB *******************/

/****************** Family Psychological Status TAB ********************/
	function addfamilypsycho()
	{
		$this->load->model('Surveymodel');
		$this->Surveymodel->family_psychological_status_insert();
		
		extract($_POST);
		
		$rec = $this->Surveymodel->get_family_psychological_status($hdnSurveyId);
		
		foreach($rec as $row)
		{
			
			echo '<tr>';
			echo '<td>';
			echo '<div class="col-md-11">';
			echo '<span class="font-blue">' . $row->psychological_status .'</span></div>';
			echo '<div class="col-md-1"><button id="btnDeletedoc" name="btnDeletedoc" type="button" 
								  class="btn btn-circle red-sunglo btn-sm" 
								  onclick="delete_family_psycho('. $row->family_psychological_status_id .','
																 . $row->psychological_status_id .')">
								   <i id="iConst" class="fa fa-close"></i>
						  </div>';
			echo "</td>";
			echo "</tr>";
		}
		
		
	}
	function deletefamilypsycho()
	{
		$this->load->model('Surveymodel');
		$this->Surveymodel->family_psychological_status_delete();
		
		extract($_POST);
		
		$rec = $this->Surveymodel->get_family_psychological_status($hdnSurveyId);
		
		foreach($rec as $row)
		{
			
			echo '<tr>';
			echo '<td>';
			echo '<div class="col-md-11">';
			echo '<span class="font-blue">' . $row->psychological_status .'</span></div>';
			echo '<div class="col-md-1"><button id="btnDeletedoc" name="btnDeletedoc" type="button" 
								  class="btn btn-circle red-sunglo btn-sm" 
								  onclick="delete_family_psycho('. $row->family_psychological_status_id .','
																 . $row->psychological_status_id .')">
								   <i id="iConst" class="fa fa-close"></i>
						  </div>';
			echo "</td>";
			echo "</tr>";
		}
	}
/***************** END Family Psychological Status TAB ******************/
/********************** Life Improvement TAB ****************************/
	function addelifeImprov()
	{
		$this->load->model('Surveymodel');
		$this->Surveymodel->insert_lifeImprovement();
		
	}
	function updatelifeImprov()
	{
		$this->load->model('Surveymodel');
		$this->Surveymodel->update_lifeImprovement();
	}
//************** Coopertive Family************//

	function addcooperFamily()
	{
		$this->load->model('Surveymodel');
		$this->Surveymodel->insert_cooperFamily();
		
	}
	function updatecooperFamily()
	{
		$this->load->model('Surveymodel');
		$this->Surveymodel->update_cooperFamily();
	}



//***************end Coopertive Family*********//	
	
	/*function getfamilymember()
	{
		$this->load->model('Surveymodel');
		
		extract($_POST);
		$rec=$this->Surveymodel->get_familyMember_by_survey_id($hdnSurveyId);
		
		foreach($rec as $row)
		{
			echo '<option value="'.$row->family_member_id.'">';
			echo $row->member_name.' ( '.$row->relationship.')';
			echo '</option>';
		}
	}*/
/********************** END Life Improvement TAB **************************/

//*************************check family member id ****************************
function check_familymember_id()
	{
		$this->load->model('Surveymodel');
		$rec=$this->Surveymodel->check_familyMember_id();
		
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
		
		$temp['member_name'] = $row->member_name;
		$temp['member_sex_id'] = $row->member_sex_id;
		$temp['relationship_id'] = $row->relationship_id;
		$temp['status_id'] = $row->status_id;
		$temp['dob'] = $row->dob;
		$temp['education_level'] = $row->education_level;
		$temp['health_status_id'] = $row->health_status_id;
		$temp['income_shekel'] = $row->income_shekel;
		$temp['job'] = $row->job;
		
			array_push($output,$temp);
			
			
			header('Access-Control-Allow-Origin: *');
			header("Content-Type: application/json");
			echo json_encode($output);
		}
}	
//**************************family_member_id*************************
//************************** survey procedure*************************

	/*function addsurvey()
	{
		$this->load->model('Surveymodel');
		$result->Surveymodel->insert_survey();
		echo $result;
	}*/
	

function get_survey_data()
	{
		$this->load->model('Surveymodel');
		$rec=$this->Surveymodel->get_survey_info();
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
		
		$temp['SurveyId'] = $row->survey_id;
		$SurveyId=$row->survey_id;
		$temp['dpVisitdate'] = $row->visit_date;
		$temp['txtVisittime'] = $row->visit_time;
		$temp['txtVisitendtime'] = $row->visit_end_time;
		$temp['drpResearcher'] = $row->researcher_id;
		$temp['drpResearcherass1'] = $row->researcher_assistant_fst_id;
		$temp['drpResearcherass2'] = $row->researcher_assistant_sec_id;
			array_push($output,$temp);
			
			
			header('Access-Control-Allow-Origin: *');
			header("Content-Type: application/json");
			echo json_encode($output);
		}
		

}	

//*************************end survey fuction****************************
//************************** home status function*************************


/*
function get_homeStatus_data()
	{
		$this->load->model('Surveymodel');
		$rec=$this->Surveymodel->get_homeStatus_info($SurveyId);
		
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
		
		$temp['drpHomeStatus'] = $row->home_situation_id;
		$temp['drpHomeType'] = $row->home_type_id;
		$temp['drpCeilingType'] = $row->ceiling_type_id;
		$temp['drpFurnitureLevel'] = $row->furniture_level_id;
		
			array_push($output,$temp);
			
			
			header('Access-Control-Allow-Origin: *');
			header("Content-Type: application/json");
			echo json_encode($output);
		}
}	
*/
//*********************** Elder room status function****************	//


//****************end elder room status function******//

//*********************** Elder family relation function****************	//



//*********************** Recomendation function****************	//

	function recomendation()
	{
		$this->load->model('constantmodel');
		$this->data['survey_CashAidType'] = $this->constantmodel->get_sub_constant(47);
		$this->data['survey_NutritionType'] = $this->constantmodel->get_sub_constant(48);
		$this->data['survey_PsychologicalSupport'] = $this->constantmodel->get_sub_constant(49);
		$this->data['survey_HomeImprovRecomend'] = $this->constantmodel->get_sub_constant(50);


		if(isset($_SESSION['update']))
		{
	/*		$this->load->model('employeemodel');
			$this->data['employee_info'] = $this->employeemodel->get_employee_info($_SESSION['update']);
		*/	
		}
	}
	
	function addaidrecomend()
	{
		$this->load->model('Surveymodel');
		$this->Surveymodel->insert_aidrecomend();
	}
	function addmedicalaid()
	{
		$this->load->model('Surveymodel');
		$this->Surveymodel->insert_medicalaid();
		return $this->drawmedicalaidTable();
	}
	function addhomeaid()
	{
		$this->load->model('Surveymodel');
		$this->Surveymodel->insert_homeaid();
		return $this->drawhomeaidTable();
	}
//*****************UPDATES*****************************//	
	function updateaidrecomend()
	{
		$this->load->model('Surveymodel');
		$this->Surveymodel->update_aidrecomend();
	}
	/*function updatemedicalaid()
	{
		$this->load->model('Surveymodel');
		$this->Surveymodel->update_medicalaid();
		return $this->drawmedicalaidTable();
	}*/
	/*function updatehomeaid()
	{
		$this->load->model('Surveymodel');
		$this->Surveymodel->update_homeaid();
	}*/
	function drawmedicalaidTable()
	{
				extract($_POST);
		
		$this->load->model('Surveymodel');
		$rec = $this->Surveymodel->get_medicalaid_by_survey_id($hdnSurveyId);
		
				$i=1;
				foreach($rec as $row)
				{
				 
					echo "<tr>";
					
					echo '<td style="display:none;" id="surveyId_tb'.$i.'">'. $row->medical_aid_recomendation_id. "</td>";
					echo '<td style="display:none;" id="medical_aid_type_id_tb'.$i.'">'. $row->medical_aid_type_id. "</td>";
					echo '<td id="medicalaid_type'.$i.'">'. $row-> medicalaid_type . "</td>";
					echo '<td><button id="btnDeletedoc" name="btnDeletedoc" type="button" 
									  class="btn btn-circle red-sunglo btn-sm" 
									  onclick="deletemedicalaidbyId('.$row->medical_aid_recomendation_id.','. $row->medical_aid_type_id .')">
									   <i id="iConst" class="fa fa-close"></i>
									   </td>';
					echo "</tr>";
					
					
					
				}


	}
	function deletemedicalaidbyId()
	{
		$this->load->model('Surveymodel');
		$this->Surveymodel->delete_medicalaid();
		$this->drawmedicalaidTable();
	}
	function drawhomeaidTable()
	{
		extract($_POST);
		
		$this->load->model('Surveymodel');
		$rec = $this->Surveymodel->get_homeaid_by_survey_id($hdnSurveyId);
		
		$i=1;
		foreach($rec as $row)
		{
		 	if ($row->improvement_type_id == 168)
				$details = "فيمة الإيجار الشهري : ";
			else if ($row->improvement_type_id == 169)
				$details = "تفصيل الأشياء الأخرى : ";
			else
				$details = "";
				
			echo "<tr>";
			echo '<td style="display:none;" id="surveyId_tb'.$i.'">'. $row->home_improvement_recomendation_id. "</td>";
			echo '<td style="display:none;" id="improvement_type_id_id_tb'.$i.'">'. $row->improvement_type_id. "</td>";
			echo '<td id="homeaid_type'.$i.'">
					<div class="col-md-3">'. $row-> homeaid_type . '</div>
					<div class="col-md-6">'. $details . ' ' . $row-> improvement_details.'</div></td>';
			echo '<td><button id="btnDeletedoc" name="btnDeletedoc" type="button" 
							  class="btn btn-circle red-sunglo btn-sm" 
							  onclick="deletehomeaidbyId('.$row->home_improvement_recomendation_id.','
														  . $row->improvement_type_id .')">
							   <i id="iConst" class="fa fa-close"></i>
							   </td>';
			echo "</tr>";
			
			
			
		}


	}
function deletehomeaidbyId()
{
	$this->load->model('Surveymodel');
	$this->Surveymodel->delete_homeaid();
	$this->drawhomeaidTable();
}


function get_region()
	{
		$this->load->model('Surveymodel');
		$rec=$this->Surveymodel->get_region_list();
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
		$this->load->model('Surveymodel');
		$rec=$this->Surveymodel->get_fulladress_list();
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