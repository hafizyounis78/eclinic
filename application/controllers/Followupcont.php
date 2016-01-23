<?php
class Followupcont extends CI_Controller 
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
	function followupform()
	{
		
		$this->load->model('Employeemodel');
		$this->data['followup_research_info'] = $this->Employeemodel->get_all_employee();
		
		if(isset($_SESSION['update']))
		{
			$this->load->model('Followupmodel');
			$this->data['followup_info'] =$this->Followupmodel->get_followup_by_elderid($_SESSION['update']);
			$this->data['elder_info'] =$this->Followupmodel->get_elder_byid($_SESSION['update']);
			
		}
		
	}
	
/************************* ELDER TAB ************************/
	
	function addfollowup()
	{
		$this->load->model('Followupmodel');
		$this->Followupmodel->insert_followup();
		$this->drawfollowupTable();
		
	}
	
	function updatefollowup()
	{
		$this->load->model('Followupmodel');
		$this->Followupmodel->update_followup();
		$this->drawfollowupTable();
		
		
	}
	function deletefollowup()
	{
		$this->load->model('Followupmodel');
		$this->Followupmodel->delete_followup();
		$this->drawfollowupTable();		
		
	}
	function senddata()
	{
		extract($_POST);
		$_SESSION['update'] = $elder_id;
	}

	//************************check elder id 
	function get_elder_info()
	{
		$this->load->model('Followupmodel');
		$rec=$this->Followupmodel->get_elder_by_id();
			
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
			
	}
//end 	check elder id 

	function drawfollowupTable()
	{		
		extract($_POST);
		
		$this->load->model('Followupmodel');
		$rec = $this->Followupmodel->get_followup_by_elderid($txtElderId);
//	$this->data['familymember_info'] =$this->Familymodel->get_familyMember_by_elder_id($_SESSION['update']);
		$i=1;
		foreach($rec as $row)
		{
			echo "<tr>";
			echo "<td>" . $i++ . "</td>";
			echo '<td style="display:none;" id="follow_up_id_tb'.$i.'">'. $row->follow_up_id . "</td>";
			echo '<td id="visit_date_tb'.$i.'">'. $row->visit_date . "</td>";
			echo '<td id="visit_time_tb'.$i.'">'. $row->visit_time . "</td>";
			echo '<td id="visit_end_time_tb'.$i.'">'. $row->visit_end_time. "</td>";
			echo '<td style="display:none;" id="researcher_id_tb'.$i.'">'. $row->researcher_id . "</td>";
			echo '<td>'. $row->Researcher_name . "</td>";
			echo '<td id="visit_reason_tb'.$i.'">'. $row->visit_reason ."</td>";
			echo '<td id="notes_tb'.$i.'">'. $row->notes ."</td>";
			echo '<td id="recommendation_tb'.$i.'">'. $row->recommendation ."</td>";
			echo '<td><button id="btnDeletedoc" name="btnDeletedoc" type="button" 
							  class="btn btn-circle red-sunglo btn-sm" 
							  onclick="deleteFollowupbyId('. $row->follow_up_id.')">
							   <i id="iConst" class="fa fa-close"></i>
							   <button id="btnUpdatedoc" name="btnUpdatedoc" type="button" 
							  class="btn btn-circle red-sunglo btn-sm" 
							  onclick="updateFollowup('.$i.')">
							   <i id="iConst" class="fa fa-edit"></i>
					  </button></td>';
			echo "</tr>";
			
		}

	}
}
?>