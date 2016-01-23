<?php
class Familycont extends CI_Controller 
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
	
	function get_elder_family_info()
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
			$temp['txtName'] 	 		= $row->name;
			
			array_push($output,$temp);
			
			
			header('Access-Control-Allow-Origin: *');
			header("Content-Type: application/json");
			echo json_encode($output);
		}
		
		$this->load->model('Familymodel');
		$rec = $this->Familymodel->get_familyMember_by_elder_id($_SESSION['update']);
		
		$i=1;
		foreach($rec as $row)
		{
			
			echo "<tr>";
			echo "<td>" . $i++ 					. "</td>";
			echo "<td>" . $row->member_name 	. "</td>";
			echo "<td>" . $row->member_id 		. "</td>";
			echo "<td>" . $row->sex 			. "</td>";
			echo "<td>" . $row->relationship 	. "</td>";
			echo "<td>" . $row->fmstatus 		. "</td>";
			echo "<td>" . $row->dob 			. "</td>";
			echo "<td>" . $row->education_level . "</td>";
			echo "<td>" . $row->health_status 	. "</td>";
			echo "<td>" . $row->job 			. "</td>";
			echo "<td>" . $row->income_shekel 	. "</td>";
			echo '<td><button id="btnDeletedoc" name="btnDeletedoc" type="button" 
                              class="btn btn-circle red-sunglo btn-sm" 
                              onclick="deleteFamilybyId('. $row->family_member_id .')">
                               <i id="iConst" class="fa fa-close"></i>
                      </button></td>';
			echo "</tr>";
			
			
			
		}
	
		
		
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
			$temp['txtRegion'] 			= $row->region;
			$temp['txtFulladdress'] 	= $row->full_address;
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

//******************* FAMILY MEMBER data ************************/

	function addfamilymember()
	{
		$this->load->model('Familymodel');
		$this->Familymodel->insert_familyMember();
		$this->drawfamilyTable();

	}

	function updatefamilymember()
	{
		$this->load->model('Familymodel');
		$this->Familymodel->update_familyMember();
		$this->drawfamilyTable();
	}
	function deletefamilymember()
	{
		$this->load->model('Familymodel');
		$this->Familymodel->delete_familyMember();
		$this->drawfamilyTable();
		
	}
	function drawfamilyTable()
	{		
			extract($_POST);
			
			$this->load->model('Familymodel');
			$rec = $this->Familymodel->get_familyMember_by_elder_id($txtElderId);
	//	$this->data['familymember_info'] =$this->Familymodel->get_familyMember_by_elder_id($_SESSION['update']);
			
					$i=1;
					foreach($rec as $row)
					{
					 
						echo "<tr>";
						echo "<td>" . $i++ . "</td>";
						echo '<td id="member_name_td'.$i.'">'. $row->member_name . "</td>";
						echo '<td id="member_id_td'.$i.'">'. $row->member_id . "</td>";
						echo '<td>'. $row->sex . "</td>";
						echo '<td style="display:none;" id="surveyId_tb'.$i.'">'. $row->survey_id . "</td>";
						echo '<td style="display:none;" id="sex_td'.$i.'">'. $row->member_sex_id . "</td>";
						echo '<td>'. $row->relationship ."</td>";
						echo '<td style="display:none;" id="relationship_td'.$i.'">'. $row->relationship_id ."</td>";
						echo '<td>'. $row->fmstatus ."</td>";
						echo '<td style="display:none;" id="fmstatus_td'.$i.'">'. $row->status_id ."</td>";
						echo '<td id="dob_td'.$i.'">'. $row->dob . "</td>";
						echo '<td>'. $row->education_level . "</td>";
						echo '<td style="display:none;" id="education_level_td'.$i.'">'. $row->education_level_id . "</td>";
						echo '<td>'. $row->health_status . "</td>";
						echo '<td style="display:none;" id="health_status_td'.$i.'">'. $row->health_status_id . "</td>";
						echo '<td id="job_td'.$i.'">'. $row->job . "</td>";
						echo '<td id="income_shekel_td'.$i.'">'. $row->income_shekel . "</td>";
						echo '<td><button id="btnDeletedoc" name="btnDeletedoc" type="button" 
										  class="btn btn-circle red-sunglo btn-sm" 
										  onclick="deleteFamilybyId('. $row->family_member_id .')">
										   <i id="iConst" class="fa fa-close"></i>
										   <button id="btnUpdatedoc" name="btnUpdatedoc" type="button" 
										  class="btn btn-circle red-sunglo btn-sm" 
										  onclick="updateFamilymember('.$i.')">
										   <i id="iConst" class="fa fa-edit"></i>
								  </button></td>';
						echo "</tr>";
						
						
						
					}
	
	}
	
	function familyform()
	{
		//$this->load->model('Familymodel');
		//$this->data['familymember_info'] =$this->Familymodel->get_familyMember_by_elder_id();
		$this->load->model('constantmodel');
		$this->data['survey_FamilyMember'] = $this->constantmodel->get_sub_constant(46);
		$this->data['survey_Educationlevel'] = $this->constantmodel->get_sub_constant(23);
		$this->data['survey_Relationship'] = $this->constantmodel->get_sub_constant(4);
		$this->data['survey_Maritalstatus'] = $this->constantmodel->get_sub_constant(2);
		$this->data['survey_Health'] = $this->constantmodel->get_sub_constant(28);
		if(isset($_SESSION['update']))
		{
			$this->load->model('Familymodel');
			$this->data['familymember_info'] =$this->Familymodel->get_familyMember_by_elder_id($_SESSION['update']);
			$this->data['elder_info'] =$this->Familymodel->get_elder_by_id($_SESSION['update']);
			
		}
		
	
	
	}
	function senddata()
	{
		extract($_POST);
		$_SESSION['update'] = $elder_id;
	}
//*************************check family member id ****************************
	function check_familymember_id()
	{
		$this->load->model('Familymodel');
		$rec=$this->Familymodel->check_familyMember_id();
		
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

			$temp['elder_id'] 			= $row->elder_id;
			$temp['member_name'] 		= $row->member_name;
			$temp['member_sex_id'] 		= $row->member_sex_id;
			$temp['relationship_id'] 	= $row->relationship_id;
			$temp['status_id'] 			= $row->status_id;
			$temp['dob'] 				= $row->dob;
			$temp['education_level'] 	= $row->education_level_id;
			$temp['health_status_id'] 	= $row->health_status_id;
			$temp['income_shekel'] 		= $row->income_shekel;
			$temp['job'] 				= $row->job;
		
			array_push($output,$temp);
			
		}
		
		header('Access-Control-Allow-Origin: *');
		header("Content-Type: application/json");
		echo json_encode($output);
	}	
//**************************family_member_id*************************
}

?>