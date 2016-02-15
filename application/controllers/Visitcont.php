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
		//unset($_SESSION['updateVisit']);
		
	}
	
	/******************* USER FORM *****************************/
	function visitform()
	{
		$this->load->model('constantmodel');
		$this->load->model('visitmodel');
		$this->load->model('labmodel');
		$this->data['visittype']= $this->constantmodel->get_sub_constant(75);
		$this->data['plantype']= $this->visitmodel->get_nut_plan_list();
		$this->data['labTests'] = $this->labmodel->get_lab();
		
		//$this->data['LabOrderTest'] = $this->labmodel->get_lab_order_by_id();

//		$this->data['visittype']= $this->constantmodel->get_sub_constant(3);
		
		if(isset($_SESSION['update']))
			{
				$this->load->model('visitmodel');
				$this->data['patient_info'] = $this->visitmodel->get_patient_by_id($_SESSION['update']);
				//unset($_SESSION['update']);
				//$this->data['labTests'] = $this->labmodel->get_lab();
				
			}
	/*	else if(isset($_SESSION['updateVisit']))
			{
				$this->load->model('visitmodel');
				
				$this->data['visit_info'] = $this->visitmodel->get_visit_data_by_id($_SESSION['updateVisit']);
				unset($_SESSION['updateVisit']);
				$this->data['labTests'] = $this->labmodel->get_lab();
			}
		*/
	}
	/***********************************************************/
	function visits()
	{
		$this->load->model('constantmodel');
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
	/*function visit()
	{
		$this->load->model('constantmodel');

		
	}
	*/
	function addtest()
	{
			$this->load->model('labmodel');
			$result=$this->labmodel->add_lab_order();
			
			$this->drawTesttable($result);
			
	}
	function addTestResult()
	{
			$this->load->model('labmodel');
			$result=$this->labmodel->add_test_result();
		
	}
		
	function drawTesttable($Orders)
	{
		extract($_POST);
		$this->load->model('labmodel');
		
		//$rec = $this->labmodel->get_lab_order_by_id($hdnLabOrderNo);
		$i=$hdnCountLabOrder+1;
/*		$Orders->lab_order_details_no;
		$Orders->lab_order_no*/
		echo  $Orders->lab_order_no;
		$rec = $this->labmodel->get_orderitems($Orders->lab_order_details_no);
		$ItemName = $this->labmodel->get_item_desc($drpTestName);
		foreach($ItemName as $row)
		{
			
			echo '<tr>
					<td>'.$i.'</td>
				  	<td colspan="2">
				  		<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_2'.$i.'">'
					.$row->NAME_EN.'</a></td>
				</tr>';
				//$j=0;
				echo '<tr id="collapse_2'.$i.'" class="panel-collapse collapse"><td>&nbsp;</td>
				  <td>';
			foreach($rec as $itemrow)
			{
					
					  echo'<div class="col-md-9">
					  <div class="col-md-2">'.$itemrow->NAME_EN.'</div>
					  <div class="col-md-4">
					  <input type="text" id="txt'.$itemrow->C_TEST_ITEM_ID.'" name="txt'.$itemrow->NAME_EN.'" class="form-control" value="" />
					  </div>
					  <div class="col-md-2">
						<button id="btnAddTest" name="btnAddTest" type="button" class="btn btn-circle green-turquoise btn-sm" onclick="addResult('.$itemrow->lab_order_results_id.')">
						<i id="iConst" class="fa fa-plus"></i></button>
					  </div>
					  </div>';
			}
			echo '</td>';
			echo '<td>&nbsp;</td>';
		}
		
	}
	
			
			
	

	function visitsgriddata()
	{
		$this->load->model('visitmodel');
		$rec = $this->visitmodel->get_search_visits($_REQUEST);
		
		
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
			
			$btn='<a class="btn default btn-xs purple" onclick="gotoUpdateVisit(\''.$row->outpatient_visit_id.'\')">
			  <i class="fa fa-edit"></i> تعديل </a>';
			
			$nestedData[] = $i++;
			$nestedData[] = $row->outpatient_visit_id;
			$nestedData[] = $row->patient_file_id;
			$nestedData[] = $row->name;
			$nestedData[] = $row->visit_date;
			$nestedData[] = $row->weight;
			$nestedData[] = $row->length;
			$nestedData[] = $row->bmi;
			$nestedData[] = $row->visit_type;

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
function getvisstdata(){
	
		extract($_POST);
		$_SESSION['updateVisit'] = $VisitNo;
		unset($_SESSION['update']);
		
/*
		$this->load->model('visitmodel');
		$rec=$this->visitmodel->get_visit_data_by_id();
//		$SurveyId=0;
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
		
		$temp['patient_file_id'] = $row->patient_file_id ;			
		$temp['name'] = $row->name ;		
		$temp['dob'] = $row->dob;
		$temp['visit_date'] = $row->visit_date ;			
		$temp['visit_time'] = $row->visit_time ;		
		$temp['visit_type_id'] = $row->visit_type_id;
	
		$temp['weight'] = $row->weight ;		
		$temp['length'] = $row->length ;			
		$temp['bmi'] = $row->bmi;

		$temp['plan_id'] = $row->plan_id ;		
		$temp['start_date'] = $row->start_date ;		
		$temp['end_date'] = $row->end_date;
		$temp['breakfast'] = $row->breakfast ;			
		$temp['lunch'] = $row->lunch ;		
		$temp['dinner'] = $row->dinner;
		$temp['notes'] = $row->notes;
			array_push($output,$temp);
		}
		header('Access-Control-Allow-Origin: *');
			header("Content-Type: application/json");
			echo json_encode($output);
			*/
}		
function get_nut_plan()

	{
		$this->load->model('visitmodel');
		$rec=$this->visitmodel->get_nut_plan_by_id();
//		$SurveyId=0;
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
		$temp['breakfast'] = $row->breakfast ;			
		$temp['lunch'] = $row->lunch ;		
		$temp['dinner'] = $row->dinner;

		
			array_push($output,$temp);
			
			
			
		}
		header('Access-Control-Allow-Origin: *');
			header("Content-Type: application/json");
			echo json_encode($output);

}	
}
?>