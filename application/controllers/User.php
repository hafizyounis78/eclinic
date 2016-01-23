<?php
class User extends CI_Controller 
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
	
	/******************* USER FORM *****************************/
	function userform()
	{
		$this->load->model('constantmodel');
		$this->data['user_type'] = $this->constantmodel->get_sub_constant(20);
		
		if(isset($_SESSION['update']))
		{
			$this->load->model('usermodel');
			$this->data['user_info'] = $this->usermodel->get_user_info($_SESSION['update']);
			
		}
	}
	/***********************************************************/
	
	/******************* ADD USER ******************************/
	function adduser()
	{
		$this->load->model('usermodel');
		$this->usermodel->user_insart();
	}
	/************************************************************/
	
	/******************* Update USER ******************************/
	function updateuser()
	{
		$this->load->model('usermodel');
		$this->usermodel->user_update();
	}
	
	function senddata()
	{
		extract($_POST);
		$_SESSION['update'] = $username;
	}
	
	/************************************************************/
	
	
	
	/******************* USER DATA GRID *************************/
	function users()
	{
		$this->load->model('constantmodel');
		$this->data['job_title'] = $this->constantmodel->get_sub_constant(3);
		$this->data['user_type'] = $this->constantmodel->get_sub_constant(20);
		$this->data['job_title'] = $this->constantmodel->get_sub_constant(3);
	}
	function updateacount()
	{
		$this->load->model('usermodel');
		$this->usermodel->update_account_status();
	}
	function resetpassword()
	{
		$this->load->model('usermodel');
		$this->usermodel->reset_password();
	}
	function usergriddata()
	{
		$this->load->model('usermodel');
		$rec = $this->usermodel->get_search_users($_REQUEST);
		
		$i = 1;
		$data = array();
		foreach($rec as $row)
		{
			$nestedData=array();
			
			if ($row->active_account == 1)
			{
				$active = '<i id="i'.$row->user_name.'" class="fa fa-user font-green" 
							onclick="updateUserstatus(\''.$row->user_name.'\')" style="cursor:pointer"></i>';
				$active = $active .'&nbsp;&nbsp;&nbsp;&nbsp';
				
				$active = $active .'<a href="#" data-onclick="resetPassword(\''.$row->user_name.'\')" 
							data-toggle="modal" data-target="#confirm-reset" role="button" >';
				$active = $active .'<i class="fa fa-refresh"></i></a>';
				
			}
			else
			{
				$active = '<i id="i'.$row->user_name.'" class="fa fa-user font-red-sunglo" 
							onclick="updateUserstatus(\''.$row->user_name.'\')" style="cursor:pointer"></i>';
				$active = $active .'&nbsp;&nbsp;&nbsp;&nbsp';
				
				$active = $active .'<a href="#" data-onclick="resetPassword(\''.$row->user_name.'\')" 
							data-toggle="modal" data-target="#confirm-reset" role="button" >';
				$active = $active .'<i class="fa fa-refresh"></i></a>';
			}
				
			
			$btn = '<a class="btn default btn-xs purple" onclick="gotoUser(\''.$row->user_name.'\')">
			  		<i class="fa fa-edit"></i> تعديل </a>';
			
			$nestedData[] = $i++;
			$nestedData[] = $row->user_name;
			$nestedData[] = $row->emp_id;
			$nestedData[] = $row->name;
			$nestedData[] = $row->job_title;
			$nestedData[] = $row->user_type;
			
			$nestedData[] = $active;
			$nestedData[] = $btn;
			
			$data[] = $nestedData;
		} // End Foreach
		
		$totalFiltered = count($rec);
		$totalData = $this->usermodel->count_users();
		//$records["draw"] = $sEcho;
		$json_data = array(
					"draw"            => intval( $_REQUEST['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
					"recordsTotal"    => intval( $totalData ),  		// total number of records
					"recordsFiltered" => intval( $totalFiltered ),		// total number of records after searching, if there is no searching then totalFiltered = totalData
					"data"            => $data   						// total data array
					);
		
		echo json_encode($json_data);  // send data as json format
	}
	/************************************************************/
	
	// Auto-Complete
	function getemp($query)
	{
		$query = urldecode($query);
		$this->load->model('employeemodel');
		$rec = $this->employeemodel->search_employee_hasnt_account($query);
		
		$output = array();
		foreach($rec as $row)
		{
			unset($temp); // Release the contained value of the variable from the last loop
			$temp = array();

			// It guess your client side will need the id to extract, and distinguish the ScoreCH data
			$temp['employee_id'] = $row->employee_id;
			$temp['emp_id'] = $row->emp_id;
			$temp['name']   = $row->name;
			$temp['tokens'] = array($query, $query . rand(1, 10));
			
			array_push($output,$temp);
			
		}
		
		echo json_encode($output);		
	}
	
	// Check Username Availability
	function availabileusername()
	{
		extract($_POST);
		
		$this->load->model('usermodel');
		$rec = $this->usermodel->check_username();
		
		if (count($rec) == 0 ) {
			echo 'true';
		} else {
			echo 'false';
		}
	}
}
?>