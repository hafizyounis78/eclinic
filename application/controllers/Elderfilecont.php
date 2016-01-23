<?php
class Elderfilecont extends CI_Controller 
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
	function elderfile()
	{
		$this->load->model('constantmodel');
		
		$this->data['file_status'] 	   = $this->constantmodel->get_sub_constant(51);
		$this->data['doc_type']    	   = $this->constantmodel->get_sub_constant(27);
		$this->data['close_resone']    = $this->constantmodel->get_sub_constant(52);
		
		$this->data['eldercategory']   = $this->constantmodel->get_sub_constant(53);
		$this->data['status']          = $this->constantmodel->get_sub_constant(2);
		$this->data['governorate']     = $this->constantmodel->get_sub_constant(22);
		$this->data['governorate']     = $this->constantmodel->get_sub_constant(22);

		
		$this->data['education_level'] = $this->constantmodel->get_sub_constant(23);
		$this->data['specialization']  = $this->constantmodel->get_sub_constant(24);
		$this->data['current_job']     = $this->constantmodel->get_sub_constant(25);
		$this->data['previous_job']    = $this->constantmodel->get_sub_constant(26);
		$this->data['insurance_type']  = $this->constantmodel->get_sub_constant(7);
		
		if(isset($_SESSION['update']))
		{
			$this->load->model('elderfilemodel');
			$this->load->model('eldermodel');
			$this->data['elder_file'] = $this->elderfilemodel->get_elder_file($_SESSION['update']);
			$this->data['elder_info'] = $this->eldermodel->get_elder_by_id($_SESSION['update']);
			foreach ($this->data['elder_info'] as $row);
				{	
					$this->data['region']     = $this->constantmodel->get_region_list($row->governorate_id);
					$this->data['fulladdress']     = $this->constantmodel->get_region_list($row->region);
				}
			foreach ($this->data['elder_file'] as $row);
			$this->data['elder_docs'] = $this->elderfilemodel->get_elder_doc($row->file_id);
			
		}
		
	}
	
	function updatefile()
	{
		
		$this->load->model('elderfilemodel');
		$this->elderfilemodel->file_update();
		
	}
	function updateelder()
	{
		$this->load->model('Surveymodel');
		$this->Surveymodel->update_elder();
	}
	function uploaddoc()
	{
		
		$this->load->model('elderfilemodel');
		$this->elderfilemodel->elder_doc_insert();
		
		extract($_POST);
		$rec = $this->data['elder_docs'] = $this->elderfilemodel->get_elder_doc($fileid);
		
		if ($_SERVER['SERVER_NAME'] == "localhost") $dir = "elder";
		else $dir = "app";
		
		foreach ($rec as $elder_docs_row)
		{			
			echo '<tr>';
		    echo '<td>'.$elder_docs_row->doc_type.'</td>';
		    echo '<td><a href="/'.$dir.'/docuploads/'.$elder_docs_row->doc_path.'">'
		   			   .$elder_docs_row->doc_path.'</a></td>';
		   	echo '<td><button id="btnDeletedoc" name="btnDeletedoc" type="button" 
					class="btn btn-circle red-sunglo btn-sm" 
					onclick="deleteDoc('.$elder_docs_row->elder_doc_id.',\''.$elder_docs_row->doc_path.'\')">
					  <i id="iConst" class="fa fa-close"></i>
					 </button></td>';
			echo '</tr>';
		}

	}
	
	function deletedoc()
	{
		
		
		$this->load->model('elderfilemodel');
		$this->elderfilemodel->elder_doc_delete();
		
		extract($_POST);
		$rec = $this->data['elder_docs'] = $this->elderfilemodel->get_elder_doc($fileid);
		
		if ($_SERVER['SERVER_NAME'] == "localhost") $dir = "elder";
		else $dir = "app"; 
		
		foreach ($rec as $elder_docs_row)
		{			
			echo '<tr>';
		    echo '<td>'.$elder_docs_row->doc_type.'</td>';
		    echo '<td><a href="/'.$dir.'/docuploads/'.$elder_docs_row->doc_path.'">'
		   			   .$elder_docs_row->doc_path.'</a></td>';
		   	echo '<td><button id="btnDeletedoc" name="btnDeletedoc" type="button" 
					class="btn btn-circle red-sunglo btn-sm" 
					onclick="deleteDoc('.$elder_docs_row->elder_doc_id.',\''.$elder_docs_row->doc_path.'\')">
					  <i id="iConst" class="fa fa-close"></i>
					 </button></td>';
			echo '</tr>';
		}
	}
}
?>