<?php
class Sms extends CI_Controller 
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
	
	function sendsms()
	{
		$this->load->model('constantmodel');
		$this->data['constants'] = $this->constantmodel->get_constant_for_sms();
	}
	function getvalue()
	{
		extract($_POST);
		
		if ($constantid < 0)
			$constantid = 38; // Yes/No Choice
			
		$data['constant_id'] = $constantid;
		
		$this->load->model('constantmodel');
		$rec =  $this->constantmodel->get_sub_constant($constantid);
		
		foreach ($rec as $row)
		{
		   echo ' <option value="'.$row->sub_constant_id.'">'
								  .$row->sub_constant_name.'</option>';
		}
				
	}
	function filter()
	{
		$this->load->model('SMSmodel');
		$rec = $this->SMSmodel->get_num();
		
		if (count($rec) == 0)
		{
			echo '<tr>';
		    echo '<td colspan="2" align="center"><strong><&nbsp;&nbsp; لا يوجد بيــانات &nbsp;&nbsp;></strong></td>';
			echo '</tr>';
			return;
		}
		$num = '';
		$coma = '';
		foreach ($rec as $row)
		{
			if($row->mobile_first != '')
			{
				$num = $num.$coma.$row->mobile_first;
				$coma = ',';
			}
			
			echo '<tr>';
		    echo '<td>'.$row->name.'</td>';
			echo '<td>'.$row->mobile_first.'</td>';
			echo '</tr>';
			
			
		}
		
		echo '*'.$num;
	}
	
	function smsinsert()
	{
		$user_name = "Albwwaba";
		$user_pass = "5812257";
		$sender= "PPDP";
		$type = 0;
		
		////////////////////////////////
		extract($_POST);
		$mobile= $txtMobilenum;
		$text = $txtMSG;
		
		$url = 'http://www.hotsms.ps/sendbulksms.php';
		$data = array('user_name' => $user_name,
					  'user_pass' => $user_pass,
					     'sender' => $sender,
					     'mobile' => $mobile,
					       'type' => $type,
						   'text' => $text);
		
		// use key 'http' even if you send the request to https://...
		$options = array(
			'http' => array(
				'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
				'method'  => 'POST',
				'content' => http_build_query($data),
			),
		);
		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
		if ($result === FALSE) 
		{
			echo 'حدث خطأ اثناء عملية الارسال';
		}
		//var_dump($result);
		if ($result == 1001)
		{
			$this->load->model('SMSmodel');
			$this->SMSmodel->sms_insert();
			
			echo 'تمت عملية الارسال بنجاح';
		}
		else if ($result == 1000)
		{
			echo 'عذرا!... لا بوجد رصيذ كافي';
		}
		else if ($result == 2000)
		{
			echo 'خطأ في اسم المستخدم أو كلمة المرور';
		}
		else if ($result == 3000)
		{
			echo 'نوع الرسالة خطأ';
		}
		else if ($result == 4000)
		{
			echo 'الرجـاء التأكد من القيم المدخلة';
		}
		else if ($result == 5000)
		{
			echo 'رقم الجوال خاطئ ... الرجاء التأكد من الرقم';
		}
		else if ($result == 6000)
		{
			echo 'اسم المرسل غير هقبول';
		}
		/////////////////////////////

	
	}
}
?>