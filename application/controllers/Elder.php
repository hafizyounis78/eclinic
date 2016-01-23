<?php
class Elder extends CI_Controller 
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
	function elders()
	{
		$this->load->model('constantmodel');

		$this->data['elder_governorate'] = $this->constantmodel->get_sub_constant(22);
	}
	
	function senddata()
	{
		extract($_POST);
		$_SESSION['update'] = $national_id;
	}
	
	function eldergriddata()
	{
		$this->load->model('eldermodel');
		$rec = $this->eldermodel->get_search_elder($_REQUEST);
		
		$allowFileupdate = false;
		$allowFamilyupdate = false;
		$res_menue = $this->session->userdata('menue');
		foreach($res_menue as $row)
		{
			if($row->page_id == 24)
				$allowFileupdate = true;
			if($row->page_id == 25)
				$allowFamilyupdate = true;
		}
		
		$i = 1;
		$data = array();
		foreach($rec as $row)
		{
			$btn = '';
			$nestedData=array();
			
			if ($row->isDeadElder == 1)
				$isDead = '<i class="fa fa-user font-green"></i>';
			else
				$isDead= '<i class="fa fa-user font-red-sunglo"></i>';
				
			/*$btn='<a href="'.base_url().'adduser/'.$row->user_name.'" class="btn default btn-xs purple">
			  <i class="fa fa-edit"></i> تعديل </a>';*/
			if ($allowFileupdate)
			  $btn ='<a class="btn default btn-xs purple" onclick="gotoElder(\''.$row->elder_id.'\')">
				<i class="fa fa-edit"></i>تعديل الملف </a>';
			if ($allowFamilyupdate)	
			  $btn = $btn.' <a class="btn default btn-xs purple" onclick="gotoFamilyMember(\''.$row->elder_id.'\')">
				<i class="fa fa-edit"></i>تعديل بيانات العائلة </a>';
			
			$nestedData[] = $i++;
			$nestedData[] = $row->elder_id;
			$nestedData[] = $row->name;
			$nestedData[] = $row->phone;
			$nestedData[] = $row->mobile_first;
			$nestedData[] = $row->mobile_second;
			$nestedData[] = $row->Eder_governorate;
			$nestedData[] = $isDead;
			$nestedData[] = $btn;
			
			$data[] = $nestedData;
		} // End Foreach
		
		$totalFiltered = count($rec);
		$totalData=$this->eldermodel->count_elder();
		
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
?>