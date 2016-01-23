<?php
class Constant extends CI_Controller 
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
	
	/*******************CONSTANT*******************************/
	function constants()
	{
		$this->load->model('constantmodel');
		$this->data['constants'] = $this->constantmodel->get_constant();
	}
	function sub_constants()
	{
		$this->load->model('constantmodel');
		$this->data['sub_constant'] = $this->constantmodel->get_sub_constant(1);
	}
	function addconstants()
	{
		$this->load->model('constantmodel');
		$this->constantmodel->constant_insart();
		
		$constants = $this->constantmodel->get_constant();
		
		foreach($constants as $row)
	    {
		   echo '<tr>
				  <td>
					<div class="col-md-11">
					 <span class="font-blue">'.$row->constant_name.'</span></div>
					<div class="col-md-1">
					  <a onclick="show_sub('.$row->constant_id.',\''.$row->constant_name.'\')">
					  <i class="fa fa-arrow-left font-blue"></i></a>
					</div>
				  </td>
			   </tr>';
	    }
		
	}
	function showsubconstant()
	{
		extract($_POST);
		$data['constant_id'] = $constantid;
		
		$this->load->model('constantmodel');
		$rec =  $this->constantmodel->get_sub_constant($constantid);
		
		foreach($rec as $row)
  		{
			echo '<tr>
					<td>
					  <div class="col-md-11">
					   <span class="font-blue">'.$row->sub_constant_name.'</span></div>
					  <div class="col-md-1">
						<a onclick="show_edit_sub('.$row->sub_constant_id.',\''.$row->sub_constant_name.'\')">
						<i class="fa fa-edit font-blue"></i></a>
					  </div>
					</td>
				 </tr>';
		}
		
		
	}
	function addsubconstant()
	{
		$this->load->model('constantmodel');
		$this->constantmodel->sub_constant_insart();
		
		extract($_POST);
		$rec =  $this->constantmodel->get_sub_constant($hdnConstantid);
		
		foreach($rec as $row)
  		{
			echo '<tr>
					<td>
					  <div class="col-md-11">
					   <span class="font-blue">'.$row->sub_constant_name.'</span></div>
					  <div class="col-md-1">
						<a onclick="show_edit_sub('.$row->sub_constant_id.',\''.$row->sub_constant_name.'\')">
						<i class="fa fa-edit font-blue"></i></a>
					  </div>
					</td>
				 </tr>';
		}
	}
	function updateconstants()
	{
		$this->load->model('constantmodel');
		$this->constantmodel->constant_update();
		
		$constants = $this->constantmodel->get_constant();
		
		foreach($constants as $row)
	    {
		   echo '<tr>
				  <td>
					<div class="col-md-11">
					 <span class="font-blue">'.$row->constant_name.'</span></div>
					<div class="col-md-1">
					  <a onclick="show_sub('.$row->constant_id.',\''.$row->constant_name.'\')">
					  <i class="fa fa-arrow-left font-blue"></i></a>
					</div>
				  </td>
			   </tr>';
	    }
	}
	function updatesubconstant()
	{
		$this->load->model('constantmodel');
		$this->constantmodel->sub_constant_update();
		
		extract($_POST);
		$rec =  $this->constantmodel->get_sub_constant($hdnConstantid);
		
		foreach($rec as $row)
  		{
			echo '<tr>
					<td>
					  <div class="col-md-11">
					   <span class="font-blue">'.$row->sub_constant_name.'</span></div>
					  <div class="col-md-1">
						<a onclick="show_edit_sub('.$row->sub_constant_id.',\''.$row->sub_constant_name.'\')">
						<i class="fa fa-edit font-blue"></i></a>
					  </div>
					</td>
				 </tr>';
		}
	}
	
	/*******************CONSTANT*******************************/
}
?>