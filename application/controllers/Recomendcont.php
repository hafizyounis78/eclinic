<?php
class Recomendcont extends CI_Controller 
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
		$this->load->model('Recomendmodel');
		$this->Recomendmodel->insert_aidrecomend();
	}
	function addmedicalaid()
	{
		$this->load->model('Recomendmodel');
		$this->Recomendmodel->insert_medicalaid();
		return $this->drawmedicalaidTable();
	}
	function addhomeaid()
	{
		$this->load->model('Recomendmodel');
		$this->Recomendmodel->insert_homeaid();
		return $this->drawhomeaidTable();
	}
//*****************UPDATES*****************************//	
	function updateaidrecomend()
	{
		$this->load->model('Recomendmodel');
		$this->Recomendmodel->update_aidrecomend();
	}
	/*function updatemedicalaid()
	{
		$this->load->model('Recomendmodel');
		$this->Recomendmodel->update_medicalaid();
		return $this->drawmedicalaidTable();
	}*/
	/*function updatehomeaid()
	{
		$this->load->model('Recomendmodel');
		$this->Recomendmodel->update_homeaid();
	}*/
	function drawmedicalaidTable()
	{
				extract($_POST);
		
		$this->load->model('Recomendmodel');
		$rec = $this->Recomendmodel->get_medicalaid_by_survey_id($hdnSurveyId);
		
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
	$this->load->model('Recomendmodel');
	$this->Recomendmodel->delete_medicalaid();
	$this->drawmedicalaidTable();
}
function drawhomeaidTable()
	{
				extract($_POST);
		
		$this->load->model('Recomendmodel');
		$rec = $this->Recomendmodel->get_homeaid_by_survey_id($hdnSurveyId);
		
				$i=1;
				foreach($rec as $row)
				{
				 
					echo "<tr>";
					echo '<td style="display:none;" id="surveyId_tb'.$i.'">'. $row->home_improvement_recomendation_id. "</td>";
					echo '<td style="display:none;" id="improvement_type_id_id_tb'.$i.'">'. $row->improvement_type_id. "</td>";
					echo '<td id="homeaid_type'.$i.'">'. $row-> homeaid_type . "</td>";
					echo '<td><button id="btnDeletedoc" name="btnDeletedoc" type="button" 
									  class="btn btn-circle red-sunglo btn-sm" 
									  onclick="deletehomeaidbyId('.$row->home_improvement_recomendation_id.','. $row->improvement_type_id .')">
									   <i id="iConst" class="fa fa-close"></i>
									   </td>';
					echo "</tr>";
					
					
					
				}


	}
function deletehomeaidbyId()
{
	$this->load->model('Recomendmodel');
	$this->Recomendmodel->delete_homeaid();
	$this->drawhomeaidTable();
}
}
?>