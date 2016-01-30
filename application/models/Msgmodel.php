<?php

class Msgmodel extends CI_Model
{
	
	function get_num()
	{
		extract($_POST);
		
		$columns = array( 
			7 => 'efltr.insurance_type_id',
			22 => 'efltr.governorate_id',
			0  => 'efltr.region',
			23 => 'efltr.efltr.education_level_id',
			24 => 'efltr.specialization_id',
			26 => 'efltr.previous_job_id',
			54 => 'disease_id',
			30 => 'home_situation_id',
			32 => 'ceiling_type_id',
			33 => 'furniture_level_id',
			-1 => 'has_closet',
			-2 => 'has_good_bed',
			-3 => 'has_medicine_cupboard',
			-4 => 'room_need_maintenance',
			42 => 'medication_type_id',
			-5 => 'legal_advice',
			56 => 'elder_pariah_reason_id',
			44 => 'psychological_status_id',
			45 => 'elder_work_ability_id',
			46 => 'family_member_id',
			-6 => 'can_start_project',
			47 => 'cash_aid_type_id',
			48 => 'nutrition_type_id',
			-7 => 'psychological_support',
			-8 => 'social_support',
			-9 => 'entertainment',
			50 => 'improvement_type_id');
		
		$table = array( 
			7  => 'elder_tb efltr',
			22 => 'elder_tb efltr',
			0  => 'elder_tb efltr',
			23 => 'elder_tb efltr',
			24 => 'elder_tb efltr',
			26 => 'elder_tb efltr', 
			54 => 'elder_disease_det_tb disfltr, elder_disease_tb dismstr',
			30 => 'home_status_tb hstfltr', 
			32 => 'home_status_tb hstfltr',
			33 => 'home_status_tb hstfltr',
			-1 => 'elder_room_tb rmfltr',
			-2 => 'elder_room_tb rmfltr',
			-3 => 'elder_room_tb rmfltr',
			-4 => 'elder_room_tb rmfltr',
			42 => 'medication_need_tb mednfltr', 
			-5 => 'family_elder_relationship_tb ferelfltr',
			56 => 'elder_pariah_tb prhfltr',
			44 => 'family_psychological_status_tb psychofltr',
			45 => 'life_improvement_tb impfltr',
			46 => 'life_improvement_tb impfltr',
			-6 => 'life_improvement_tb impfltr',
			47 => 'aids_recomendation_tb aidfltr',
			48 => 'aids_recomendation_tb aidfltr',
			-7 => 'aids_recomendation_tb aidfltr',
			-8 => 'aids_recomendation_tb aidfltr',
			-9 => 'aids_recomendation_tb aidfltr',
			50 => 'home_improvement_recomendation_tb hmaidfltr');
		
		
		$join = array( 
			7  => ' AND e.elder_id = efltr.elder_id ',
			22 => ' AND e.elder_id = efltr.elder_id ',
			0  => ' AND e.elder_id = efltr.elder_id ',
			23 => ' AND e.elder_id = efltr.elder_id ',
			24 => ' AND e.elder_id = efltr.elder_id ',
			26 => ' AND e.elder_id = efltr.elder_id ', 
			54 => ' AND disfltr.elder_disease_id = mstr.elder_disease_id AND s.survey_id = mstr.survey_id  ',
			30 => ' AND s.survey_id = hst.survey_id ', 
			32 => ' AND s.survey_id = hst.survey_id ',
			33 => ' AND s.survey_id = hst.survey_id ',
			-1 => ' AND s.survey_id = rmfltr.survey_id ',
			-2 => ' AND s.survey_id = rmfltr.survey_id ',
			-3 => ' AND s.survey_id = rmfltr.survey_id ',
			-4 => ' AND s.survey_id = rmfltr.survey_id ',
			42 => ' AND s.survey_id = mednfltr.survey_id ', 
			-5 => ' AND s.survey_id = ferelfltr.survey_id ',
			56 => ' AND s.survey_id = prhfltr.survey_id ',
			44 => ' AND s.survey_id = psychofltr.survey_id ',
			45 => ' AND s.survey_id = impfltr.survey_id ',
			46 => ' AND s.survey_id = impfltr.survey_id ',
			-6 => ' AND s.survey_id = impfltr.survey_id ',
			47 => ' AND s.survey_id = aidfltr.survey_id ',
			48 => ' AND s.survey_id = aidfltr.survey_id ',
			-7 => ' AND s.survey_id = aidfltr.survey_id ',
			-8 => ' AND s.survey_id = aidfltr.survey_id ',
			-9 => ' AND s.survey_id = aidfltr.survey_id ',
			50 => ' AND s.survey_id = hmaidfltr.survey_id ');
		
		$select = "SELECT e.elder_id, CONCAT(e.first_name,' ',e.middle_name,' ',e.third_name,' ',e.last_name) as name,
						  e.mobile_first, e.mobile_second ";
		$from   = " FROM elder_tb e,survey_tb s,file_tb f ";
		$where  = " WHERE f.elder_id = e.elder_id
					 AND f.file_id = s.file_id
					 AND f.file_status_id = 170 ";
		
		$order_by = " ORDER BY e.mobile_first DESC";	
		
		if(isset($drpConstant1) && $drpConstant1 != '')
		{
			$from = $from.','.$table[$drpConstant1];
			$where = $where.$join[$drpConstant1];
			if ($drpConstant1 == -7 || $drpConstant1 == -8 || $drpConstant1 == -9)
			{
				if ($drpSubconstant1 == 110)
					$where = $where.' AND '.$columns[$drpConstant1].' IS NOT NULL ';
				else if ($drpSubconstant1 == 111)
					$where = $where.' AND '.$columns[$drpConstant1].'  IS NULL ';	
			}
			else
			{
				$where = $where.' AND '.$columns[$drpConstant1].' = '.$drpSubconstant1;
			}
		}
		if(isset($drpConstant2) && $drpConstant2 != '')
		{
			if (stripos($from,$table[$drpConstant2]) == false)
			{
				$from = $from.','.$table[$drpConstant2];
				$where = $where.$join[$drpConstant2];
			}
			if ($drpConstant2 == -7 || $drpConstant2 == -8 || $drpConstant2 == -9)
			{
				if ($drpSubconstant2 == 110)
					$where = $where.' AND '.$columns[$drpConstant2].' IS NOT NULL ';
				else if ($drpSubconstant2 == 111)
					$where = $where.' AND '.$columns[$drpConstant2].'  IS NULL ';	
			}
			else
			{
				$where = $where.' AND '.$columns[$drpConstant2].' = '.$drpSubconstant2;
			}
			
		}
		if(isset($drpConstant3) && $drpConstant3 != '')
		{
			if (stripos($from,$table[$drpConstant3]) == false)
			{
				$from = $from.','.$table[$drpConstant3];
				$where = $where.$join[$drpConstant3];
			}
			if ($drpConstant3 == -7 || $drpConstant3 == -8 || $drpConstant3 == -9)
			{
				if ($drpSubconstant3 == 110)
					$where = $where.' AND '.$columns[$drpConstant3].' IS NOT NULL ';
				else if ($drpSubconstant3 == 111)
					$where = $where.' AND '.$columns[$drpConstant3].'  IS NULL ';	
			}
			else
			{
				$where = $where.' AND '.$columns[$drpConstant3].' = '.$drpSubconstant3;
			}
			
		}
		if(isset($drpConstant4) && $drpConstant4 != '')
		{
			if (stripos($from,$table[$drpConstant4]) == false)
			{
				$from = $from.','.$table[$drpConstant4];
				$where = $where.$join[$drpConstant4];
			}
			if ($drpConstant4 == -7 || $drpConstant4 == -8 || $drpConstant4 == -9)
			{
				if ($drpSubconstant4 == 110)
					$where = $where.' AND '.$columns[$drpConstant4].' IS NOT NULL ';
				else if ($drpSubconstant4 == 111)
					$where = $where.' AND '.$columns[$drpConstant4].'  IS NULL ';	
			}
			else
			{
				$where = $where.' AND '.$columns[$drpConstant4].' = '.$drpSubconstant4;
			}
			
		}
		if(isset($drpConstant5) && $drpConstant5 != '')
		{
			if (stripos($from,$table[$drpConstant5]) == false)
			{
				$from = $from.','.$table[$drpConstant5];
				$where = $where.$join[$drpConstant5];
			}
			if ($drpConstant5 == -7 || $drpConstant5 == -8 || $drpConstant5 == -9)
			{
				if ($drpSubconstant5 == 110)
					$where = $where.' AND '.$columns[$drpConstant5].' IS NOT NULL ';
				else if ($drpSubconstant5 == 111)
					$where = $where.' AND '.$columns[$drpConstant5].'  IS NULL ';	
			}
			else
			{
				$where = $where.' AND '.$columns[$drpConstant5].' = '.$drpSubconstant5;
			}
			
		}
		
		$myquery =$select.$from.$where.$order_by;
		
		$res = $this->db->query($myquery);
		return $res->result();
	}
	
	function sms_insert()
	{
		extract($_POST);
		
		date_default_timezone_set('Asia/Gaza');
		$sdata = $this->session->userdata('logged_in');
		
		$data['sms_text'] = $txtMSG;
		$data['sms_date'] = date("Y-m-d H:i:s"); ;
		$data['send_by'] = $sdata['userid'];
		//$data['send_to'] = $txtMobilenum;
		
		
		$this->db->insert('sms_tb',$data);
		$sms_id = $this->db->insert_id();
		
		$mobileNum = explode(",", $txtMobilenum);
		
		$inSelect = "";
		for($i=0; $i<count($mobileNum); $i++)
		{
			if ($i == 0)
				$inSelect = $inSelect."SELECT '".$mobileNum[$i]."' as num";
			else
				$inSelect = $inSelect." UNION ALL SELECT '".$mobileNum[$i]."' ";
   
		}
		
		/*$myquery = "INSERT INTO sms_receiver_tb
					(file_id, mobile_num, sms_id)
					(SELECT f.file_id, e.mobile_first, ".$sms_id."
					   FROM file_tb f, elder_tb e
					  WHERE f.elder_id = e.elder_id
					    AND mobile_first IN (".$txtMobilenum."))";*/
					
		   $myquery = "INSERT INTO sms_receiver_tb
						(file_id, mobile_num, sms_id)
						(SELECT f.file_id, num_list.num, ".$sms_id."
					   	   FROM               
				      	   (".$inSelect.") num_list left join elder_tb e ON num_list.num = e.mobile_first
						   left join file_tb f ON f.elder_id = e.elder_id)";
		
		$res = $this->db->query($myquery);
		
	}
}
?>