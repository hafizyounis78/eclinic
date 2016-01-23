<?php
class Usertypeperm extends CI_Controller 
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
	
	function usertypepermession ()
	{
		$this->load->model('constantmodel');
		$this->data['user_type'] = $this->constantmodel->get_sub_constant(20);
		
	}
	
	function addusertypepermession()
	{
		$this->load->model('usertypepermmodel');
		$this->usertypepermmodel->user_menu_page_insert();
	}
	
	function deleteusertypepermession()
	{
		$this->load->model('usertypepermmodel');
		$this->usertypepermmodel->user_menu_page_delete();
	}
	
	function getmenue()
	{
		$this->load->model('usertypepermmodel');
		$rec = $this->usertypepermmodel->get_not_allowed_menue();
		
		//echo '<select multiple="multiple" class="multi-select" id="my_multi_select2" name="my_multi_select2[]">';
			  $menue_id = '';
			  foreach($rec as $menue_row)
			  {
				  $selected = '';
				  if ($menue_row->allowed != '')
						$selected = 'selected';
						
				  if ($menue_id == '' )
				  {
					  $menue_id = $menue_row->menu_id;
					  echo '<optgroup label="'.$menue_row->menu_name.'">';
					  echo '<option '.$selected.' value='.$menue_row->menu_page_id.'>'.$menue_row->page_title.'</option>';
				  } 
				  else if ($menue_id != $menue_row->menu_id)
				  {
					  $menue_id = $menue_row->menu_id;
					  echo '</optgroup>';
					  echo '<optgroup label="'.$menue_row->menu_name.'">';
					  echo '<option '.$selected.' value='.$menue_row->menu_page_id.'>'.$menue_row->page_title.'</option>';
				  }
				  else
				  {
					  echo '<option '.$selected.' value='.$menue_row->menu_page_id.'>'.$menue_row->page_title.'</option>';
				  }
				  
			  }
			  echo '</optgroup>';
	}
}
?>