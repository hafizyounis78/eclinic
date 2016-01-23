<?php
class Reports extends CI_Controller 
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
	
	// Elder Person Info Report
	function elderinforpt()
	{
		$this->load->model('constantmodel');

		$this->data['elder_governorate'] = $this->constantmodel->get_sub_constant(22);
		$this->data['elder_status'] 	 = $this->constantmodel->get_sub_constant(2);
	}
	function elderinfogriddata()
	{
		$this->load->model('reportsmodel');
		$rec = $this->reportsmodel->get_eldr_info_rpt($_REQUEST);
		
		$i = 1;
		$data = array();
		foreach($rec as $row)
		{
			$nestedData=array();
						
			$nestedData[] = $i++;
			$nestedData[] = $row->file_doc_id;
			$nestedData[] = $row->elder_id;
			$nestedData[] = $row->name;
			$nestedData[] = $row->age;
			$nestedData[] = $row->status;
			$nestedData[] = $row->phone;
			$nestedData[] = $row->mobile_first;
			$nestedData[] = $row->mobile_second;
			$nestedData[] = $row->governorate;
			$nestedData[] = $row->region_desc;
			$nestedData[] = $row->fulladdress;
			$nestedData[] = '';
			
			$data[] = $nestedData;
		} // End Foreach
		
		$totalFiltered = count($rec);
		$totalData = count($rec);
		//$records["draw"] = $sEcho;
		$json_data = array(
					"draw"            => intval( $_REQUEST['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
					"recordsTotal"    => intval( $totalData ),  		// total number of records
					"recordsFiltered" => intval( $totalFiltered ),		// total number of records after searching, if there is no searching then totalFiltered = totalData
					"data"            => $data   						// total data array
					);
		
		echo json_encode($json_data);  // send data as json format
	}
//************get region**********
function get_region()
	{
		$this->load->model('Reportsmodel');
		$rec=$this->Reportsmodel->get_region_list();
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
		$this->load->model('Reportsmodel');
		$rec=$this->Reportsmodel->get_fulladress_list();
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
	


//******end get region	
	
	
	//******************************* Genger Report ****************************//
	function genderrpt()
	{
		$this->load->model('constantmodel');

		$this->data['elder_governorate'] = $this->constantmodel->get_sub_constant(22);
		$this->data['elder_sex'] 	 = $this->constantmodel->get_sub_constant(1);
	}
	function gendergriddata()
	{
		$this->load->model('reportsmodel');
		$rec = $this->reportsmodel->get_eldr_gender_rpt($_REQUEST);
		
		$i = 1;
		$data = array();
		foreach($rec as $row)
		{
			$nestedData=array();
						
			$nestedData[] = $i++;
			$nestedData[] = $row->file_doc_id;
			$nestedData[] = $row->elder_id;
			$nestedData[] = $row->name;
			$nestedData[] = $row->phone;
			$nestedData[] = $row->mobile_first;
			$nestedData[] = $row->sex;
			$nestedData[] = $row->governorate;
			$nestedData[] = $row->region_desc;
			$nestedData[] = $row->fulladdress;
			$nestedData[] = '';
			
			$data[] = $nestedData;
		} // End Foreach
		
		$totalFiltered = count($rec);
		$totalData = count($rec);
		//$records["draw"] = $sEcho;
		$json_data = array(
					"draw"            => intval( $_REQUEST['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
					"recordsTotal"    => intval( $totalData ),  		// total number of records
					"recordsFiltered" => intval( $totalFiltered ),		// total number of records after searching, if there is no searching then totalFiltered = totalData
					"data"            => $data   						// total data array
					);
		
		echo json_encode($json_data);  // send data as json format
	}
	
	
	//******************************* Education Report ****************************//
	
	function edurpt()
	{
		$this->load->model('constantmodel');

		$this->data['elder_specialization'] = $this->constantmodel->get_sub_constant(24);
		$this->data['elder_currentjob'] = $this->constantmodel->get_sub_constant(25);
		$this->data['elder_previousjob'] = $this->constantmodel->get_sub_constant(26);
		$this->data['elder_governorate'] = $this->constantmodel->get_sub_constant(22);
		
	}
	function edugriddata()
	{
		$this->load->model('reportsmodel');
		$rec = $this->reportsmodel->get_eldr_edu_rpt($_REQUEST);
		
		$i = 1;
		$data = array();
		foreach($rec as $row)
		{
			$nestedData=array();
						
			$nestedData[] = $i++;
			$nestedData[] = $row->file_doc_id;
			$nestedData[] = $row->elder_id;
			$nestedData[] = $row->name;
			$nestedData[] = $row->phone;
			$nestedData[] = $row->mobile_first;
			$nestedData[] = $row->mobile_second;
			$nestedData[] = $row->specialization;
			$nestedData[] = $row->current_job;
			$nestedData[] = $row->previous_job;
			$nestedData[] = $row->governorate;
			$nestedData[] = $row->region_desc;
			$nestedData[] = $row->fulladdress;
	
			$nestedData[] = '';
			
			$data[] = $nestedData;
		} // End Foreach
		
		$totalFiltered = count($rec);
		$totalData = count($rec);
		//$records["draw"] = $sEcho;
		$json_data = array(
					"draw"            => intval( $_REQUEST['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
					"recordsTotal"    => intval( $totalData ),  		// total number of records
					"recordsFiltered" => intval( $totalFiltered ),		// total number of records after searching, if there is no searching then totalFiltered = totalData
					"data"            => $data   						// total data array
					);
		
		echo json_encode($json_data);  // send data as json format
	}
	
	//******************************* Health Report ****************************//
	
	function elderhealthrpt()
	{
		$this->load->model('constantmodel');

		$this->data['elder_sex'] 	 = $this->constantmodel->get_sub_constant(1);
		$this->data['elder_elderdisease'] = $this->constantmodel->get_sub_constant(54);
		$this->data['elder_medicationavailable'] = $this->constantmodel->get_sub_constant(41);
		$this->data['elder_governorate'] = $this->constantmodel->get_sub_constant(22);
		
	}
	function elderhealthgriddata()
	{
		$this->load->model('reportsmodel');
		$rec = $this->reportsmodel->get_elder_health_rpt($_REQUEST);
		
		$i = 1;
		$data = array();
		foreach($rec as $row)
		{
			$nestedData=array();
						
			$nestedData[] = $i++;
			$nestedData[] = $row->file_doc_id;
			$nestedData[] = $row->elder_id;
			$nestedData[] = $row->name;
			$nestedData[] = $row->sex;
			$nestedData[] = $row->phone;
			$nestedData[] = $row->mobile_first;
			$nestedData[] = $row->mobile_second;
			$nestedData[] = $row->elder_disease;
			$nestedData[] = $row->elder_medicine;
			$nestedData[] = $row->governorate;
			$nestedData[] = $row->region_desc;
			$nestedData[] = $row->fulladdress;
	
			$nestedData[] = '';
			
			$data[] = $nestedData;
		} // End Foreach
		
		$totalFiltered = count($rec);
		$totalData = count($rec);
		//$records["draw"] = $sEcho;
		$json_data = array(
					"draw"            => intval( $_REQUEST['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
					"recordsTotal"    => intval( $totalData ),  		// total number of records
					"recordsFiltered" => intval( $totalFiltered ),		// total number of records after searching, if there is no searching then totalFiltered = totalData
					"data"            => $data   						// total data array
					);
		
		echo json_encode($json_data);  // send data as json format
	}
	
	//******************************* Income Report ****************************//
	function incomerpt()
	{
		$this->load->model('constantmodel');
		
		$this->data['elder_incomesource'] = $this->constantmodel->get_sub_constant(29);
		$this->data['elder_governorate'] = $this->constantmodel->get_sub_constant(22);
	}
	function incomegriddata()
	{
		$this->load->model('reportsmodel');
		$rec = $this->reportsmodel->get_income_rpt($_REQUEST);
		
		$i = 1;
		$data = array();
		foreach($rec as $row)
		{
			$nestedData=array();
						
			$nestedData[] = $i++;
			$nestedData[] = $row->file_doc_id;
			$nestedData[] = $row->name;
			$nestedData[] = $row->phone;
			$nestedData[] = $row->mobile_first;
			$nestedData[] = $row->mobile_second;
			$nestedData[] = $row->count_family_member;
			$nestedData[] = $row->resource;
			$nestedData[] = $row->total_income;
			$nestedData[] = $row->elder_portion;
			$nestedData[] = $row->governorate;
			$nestedData[] = $row->region_desc;
			$nestedData[] = $row->fulladdress;
			$nestedData[] = '';
			
			$data[] = $nestedData;
		} // End Foreach
		
		$totalFiltered = count($rec);
		$totalData = count($rec);
		//$records["draw"] = $sEcho;
		$json_data = array(
					"draw"            => intval( $_REQUEST['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
					"recordsTotal"    => intval( $totalData ),  		// total number of records
					"recordsFiltered" => intval( $totalFiltered ),		// total number of records after searching, if there is no searching then totalFiltered = totalData
					"data"            => $data   						// total data array
					);
		
		echo json_encode($json_data);  // send data as json format
	}
	
	
	//******************************* Home Report ****************************//
	function elderhomerpt()
	{
		$this->load->model('constantmodel');
		
		$this->data['elder_homestatus'] = $this->constantmodel->get_sub_constant(30);
		$this->data['elder_hometype'] = $this->constantmodel->get_sub_constant(31);
		$this->data['elder_ceilingtype'] = $this->constantmodel->get_sub_constant(32);
		$this->data['elder_furniturelevel'] = $this->constantmodel->get_sub_constant(33);
		
		$this->data['elder_governorate'] = $this->constantmodel->get_sub_constant(22);
	}
	
	function homegriddata()
	{
		$this->load->model('reportsmodel');
		$rec = $this->reportsmodel->get_home_status_rpt($_REQUEST);
		
		$i = 1;
		$data = array();
		foreach($rec as $row)
		{
			$nestedData=array();
						
			$nestedData[] = $i++;
			$nestedData[] = $row->file_doc_id;
			$nestedData[] = $row->name;
			$nestedData[] = $row->phone;
			$nestedData[] = $row->mobile_first;
			$nestedData[] = $row->mobile_second;
			$nestedData[] = $row->home_situation;
			$nestedData[] = $row->home_type;
			$nestedData[] = $row->ceiling_type;
			$nestedData[] = $row->ceiling_description;
			$nestedData[] = $row->furniture_level;
			$nestedData[] = $row->furniture_needs;
			$nestedData[] = $row->governorate;
			$nestedData[] = $row->region_desc;
			$nestedData[] = $row->fulladdress;
	
			$nestedData[] = '';
			
			$data[] = $nestedData;
		} // End Foreach
		
		$totalFiltered = count($rec);
		$totalData = count($rec);
		//$records["draw"] = $sEcho;
		$json_data = array(
					"draw"            => intval( $_REQUEST['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
					"recordsTotal"    => intval( $totalData ),  		// total number of records
					"recordsFiltered" => intval( $totalFiltered ),		// total number of records after searching, if there is no searching then totalFiltered = totalData
					"data"            => $data   						// total data array
					);
		
		echo json_encode($json_data);  // send data as json format
	}
	
	
	//******************************* Room Report ****************************//
	function elderroomrpt()
	{
		$this->load->model('constantmodel');
		
		$this->data['elder_hometype'] = $this->constantmodel->get_sub_constant(55);
		$this->data['elder_roomtype'] = $this->constantmodel->get_sub_constant(34);
		$this->data['elder_clothes'] = $this->constantmodel->get_sub_constant(35);
		$this->data['elder_ventilation'] = $this->constantmodel->get_sub_constant(36);
		$this->data['elder_lighting'] = $this->constantmodel->get_sub_constant(37);
		$this->data['elder_choice'] = $this->constantmodel->get_sub_constant(38);
		$this->data['elder_higiene'] = $this->constantmodel->get_sub_constant(40);
		
		$this->data['elder_governorate'] = $this->constantmodel->get_sub_constant(22);
	}
	
	function elderroomgriddata()
	{
		$this->load->model('reportsmodel');
		$rec = $this->reportsmodel->get_elder_room_rpt($_REQUEST);
		
		$i = 1;
		$data = array();
		foreach($rec as $row)
		{
			$nestedData=array();
						
			$nestedData[] = $i++;
			$nestedData[] = $row->file_doc_id;
			$nestedData[] = $row->name;
			$nestedData[] = $row->phone;
			$nestedData[] = $row->mobile_first;
			$nestedData[] = $row->mobile_second;
			$nestedData[] = $row->home_type;
			$nestedData[] = $row->room_type;
			$nestedData[] = $row->clothes_covers_status;
			$nestedData[] = $row->room_ventilation;
			$nestedData[] = $row->room_lighting;
			$nestedData[] = $row->has_closet;
			$nestedData[] = $row->has_good_bed;
			$nestedData[] = $row->has_medicine_cupboard;
			$nestedData[] = $row->elder_higiene;
			$nestedData[] = $row->governorate;
			$nestedData[] = $row->region_desc;
			$nestedData[] = $row->fulladdress;
	
			$nestedData[] = '';
			
			$data[] = $nestedData;
		} // End Foreach
		
		$totalFiltered = count($rec);
		$totalData = count($rec);
		//$records["draw"] = $sEcho;
		$json_data = array(
					"draw"            => intval( $_REQUEST['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
					"recordsTotal"    => intval( $totalData ),  		// total number of records
					"recordsFiltered" => intval( $totalFiltered ),		// total number of records after searching, if there is no searching then totalFiltered = totalData
					"data"            => $data   						// total data array
					);
		
		echo json_encode($json_data);  // send data as json format
	}
	
	//******************************* Maintenance Report ****************************//
	function maintenancerpt()
	{
		$this->load->model('constantmodel');
		
		$this->data['elder_bathroom'] = $this->constantmodel->get_sub_constant(39);
		$this->data['elder_choice'] = $this->constantmodel->get_sub_constant(38);
		
		$this->data['elder_governorate'] = $this->constantmodel->get_sub_constant(22);
	}
	
	function maintenancegriddata()
	{
		$this->load->model('reportsmodel');
		$rec = $this->reportsmodel->get_maintenance_rpt($_REQUEST);
		
		$i = 1;
		$data = array();
		foreach($rec as $row)
		{
			$nestedData=array();
						
			$nestedData[] = $i++;
			$nestedData[] = $row->file_doc_id;
			$nestedData[] = $row->name;
			$nestedData[] = $row->phone;
			$nestedData[] = $row->mobile_first;
			$nestedData[] = $row->mobile_second;
			$nestedData[] = $row->rm_need_maintenance;
			$nestedData[] = $row->room_maintenance_details;
			$nestedData[] = $row->bathroom_status;
			$nestedData[] = $row->bathroom_maintenance_details;
			$nestedData[] = $row->governorate;
			$nestedData[] = $row->region_desc;
			$nestedData[] = $row->fulladdress;
	
			$nestedData[] = '';
			
			$data[] = $nestedData;
		} // End Foreach
		
		$totalFiltered = count($rec);
		$totalData = count($rec);
		//$records["draw"] = $sEcho;
		$json_data = array(
					"draw"            => intval( $_REQUEST['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
					"recordsTotal"    => intval( $totalData ),  		// total number of records
					"recordsFiltered" => intval( $totalFiltered ),		// total number of records after searching, if there is no searching then totalFiltered = totalData
					"data"            => $data   						// total data array
					);
		
		echo json_encode($json_data);  // send data as json format
	}
	
	//**************************** Family Elder Relation Report ***************************//
	function familyelderrelationrpt()
	{
		$this->load->model('constantmodel');
		
		$this->data['elder_psychologicalstatus'] = $this->constantmodel->get_sub_constant(44);
		$this->data['elder_elderbehaviour'] = $this->constantmodel->get_sub_constant(43);
		$this->data['elder_elderpariah'] = $this->constantmodel->get_sub_constant(56);
		$this->data['elder_choice'] = $this->constantmodel->get_sub_constant(38);
		
	}
	function familyelderrelationgriddata()
	{
		$this->load->model('reportsmodel');
		$rec = $this->reportsmodel->get_family_elder_Relation_rpt($_REQUEST);
		
		$i = 1;
		$data = array();
		foreach($rec as $row)
		{
			$nestedData=array();
						
			$nestedData[] = $i++;
			$nestedData[] = $row->file_doc_id;
			$nestedData[] = $row->name;
			$nestedData[] = $row->phone;
			$nestedData[] = $row->mobile_first;
			$nestedData[] = $row->mobile_second;
			$nestedData[] = $row->is_respect;
			$nestedData[] = $row->is_care;
			$nestedData[] = $row->is_psychological_support;
			$nestedData[] = $row->is_provision_needs;
			$nestedData[] = $row->is_pariah;
			$nestedData[] = $row->family_psycho;
			$nestedData[] = $row->elder_behaviour;
			$nestedData[] = $row->elder_pariah_reason;
			$nestedData[] = $row->is_cooperative;
			$nestedData[] = $row->cooperative_persone_name;
	
			$nestedData[] = '';
			
			$data[] = $nestedData;
		} // End Foreach
		
		$totalFiltered = count($rec);
		$totalData = count($rec);
		//$records["draw"] = $sEcho;
		$json_data = array(
					"draw"            => intval( $_REQUEST['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
					"recordsTotal"    => intval( $totalData ),  		// total number of records
					"recordsFiltered" => intval( $totalFiltered ),		// total number of records after searching, if there is no searching then totalFiltered = totalData
					"data"            => $data   						// total data array
					);
		
		echo json_encode($json_data);  // send data as json format
	}
	//******************************* Life Improvement Report ****************************//
	function lifeimprovementrpt()
	{
		$this->load->model('constantmodel');
		
		$this->data['elder_elderWorkAbility'] = $this->constantmodel->get_sub_constant(45);
		$this->data['elder_familyMember'] = $this->constantmodel->get_sub_constant(46);
		$this->data['elder_choice'] = $this->constantmodel->get_sub_constant(38);
		
	}
	
	function lifeimprovementgriddata()
	{
		$this->load->model('reportsmodel');
		$rec = $this->reportsmodel->get_life_improvement_rpt($_REQUEST);
		
		$i = 1;
		$data = array();
		foreach($rec as $row)
		{
			$nestedData=array();
						
			$nestedData[] = $i++;
			$nestedData[] = $row->file_doc_id;
			$nestedData[] = $row->name;
			$nestedData[] = $row->phone;
			$nestedData[] = $row->mobile_first;
			$nestedData[] = $row->mobile_second;
			$nestedData[] = $row->elder_work_ability;
			$nestedData[] = $row->elder_work_type;
			$nestedData[] = $row->family_member;
			$nestedData[] = $row->elder_need_training;
			$nestedData[] = $row->elder_training_type;
			$nestedData[] = $row->can_start_proj;
			$nestedData[] = $row->project_type;
			$nestedData[] = $row->project_budget;
			$nestedData[] = '';
			
			$data[] = $nestedData;
		} // End Foreach
		
		$totalFiltered = count($rec);
		$totalData = count($rec);
		//$records["draw"] = $sEcho;
		$json_data = array(
					"draw"            => intval( $_REQUEST['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
					"recordsTotal"    => intval( $totalData ),  		// total number of records
					"recordsFiltered" => intval( $totalFiltered ),		// total number of records after searching, if there is no searching then totalFiltered = totalData
					"data"            => $data   						// total data array
					);
		
		echo json_encode($json_data);  // send data as json format
	}
	
	//******************************* Aid Recomendation Report ****************************//
	function aidrecomendationrpt()
	{
		$this->load->model('constantmodel');
		
		$this->data['elder_CashAidType'] = $this->constantmodel->get_sub_constant(47);
		$this->data['elder_NutritionType'] = $this->constantmodel->get_sub_constant(48);
		$this->data['elder_MedicalAid'] = $this->constantmodel->get_sub_constant(49);
		$this->data['elder_HomeImprovRecomend'] = $this->constantmodel->get_sub_constant(50);
		
	}
	function aidrecomendationgriddata()
	{
		$this->load->model('reportsmodel');
		$rec = $this->reportsmodel->get_aid_recomendation_rpt($_REQUEST);
		
		$i = 1;
		$data = array();
		foreach($rec as $row)
		{
			$nestedData=array();
						
			$nestedData[] = $i++;
			$nestedData[] = $row->file_doc_id;
			$nestedData[] = $row->name;
			$nestedData[] = $row->phone;
			$nestedData[] = $row->mobile_first;
			$nestedData[] = $row->mobile_second;
			$nestedData[] = $row->cash_aid_type;
			$nestedData[] = $row->cash_aid_amount;
			$nestedData[] = $row->medical_aid;
			$nestedData[] = $row->home_improvment;
			$nestedData[] = $row->home_rent;
			$nestedData[] = $row->other_home_aids;
			$nestedData[] = $row->nutrition_type;
			$nestedData[] = $row->nutrition_details;
			$nestedData[] = $row->psychological_support;
			$nestedData[] = $row->social_support;
			$nestedData[] = $row->entertainment;
			$nestedData[] = '';
			
			$data[] = $nestedData;
		} // End Foreach
		
		$totalFiltered = count($rec);
		$totalData = count($rec);
		//$records["draw"] = $sEcho;
		$json_data = array(
					"draw"            => intval( $_REQUEST['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
					"recordsTotal"    => intval( $totalData ),  		// total number of records
					"recordsFiltered" => intval( $totalFiltered ),		// total number of records after searching, if there is no searching then totalFiltered = totalData
					"data"            => $data   						// total data array
					);
		
		echo json_encode($json_data);  // send data as json format
	}
	
	//******************************* Statistical Report ****************************//
	function statisticalrpt()
	{
		$this->load->model('reportsmodel');
		
		$this->data['dead'] = $this->reportsmodel->get_dead_rpt();
		$this->data['file'] = $this->reportsmodel->get_file_num_rpt();
			
	}
}
?>