<?php

class Recomendmodel extends CI_Model
{
	
	
	function insert_aidrecomend()
	{
		extract($_POST);

		$data['survey_id'] 		  = $hdnSurveyId;
		$data['cash_aid_type_id'] = $drpCashaidtype;
		$data['cash_aid_amount'] = $txtCashaidamount;
		$data['nutrition_type_id'] = $drpNutritiontype;
		$data['nutrition_details'] = $txtNutritiondetails;
		$data['psychological_support'] = $chbxPsychologicalsupport;
		$data['social_support'] = $chbxSocialsupport;
		$data['entertainment'] = $chbxEntertainment;
		
		$this->db->insert('aids_recomendation_tb',$data);
	}
	function insert_medicalaid()
	{
		extract($_POST);

		$data['survey_id'] 		  = $hdnSurveyId;
		$data['medical_aid_type_id'] = $drpMedicalaidtype;
		
		
		$this->db->insert('medical_aid_recomendation_tb',$data);
	}

	function insert_homeaid()
	{
		extract($_POST);

		$data['survey_id'] 		  = $hdnSurveyId;
		$data['improvement_type_id'] = $drpImprovementtype;
		
		
		$this->db->insert('home_improvement_recomendation_tb',$data);
	}
//*******************updates*****************//
function update_aidrecomend()
	{
		extract($_POST);

	//	$data['survey_id'] 		  = $hdnSurveyId;
		$data['cash_aid_type_id'] = $drpCashaidtype;
		$data['cash_aid_amount'] = $txtCashaidamount;
		$data['nutrition_type_id'] = $drpNutritiontype;
		$data['nutrition_details'] = $txtNutritiondetails;
		$data['psychological_support'] = $chbxPsychologicalsupport;
		$data['social_support'] = $chbxSocialsupport;
		$data['entertainment'] = $chbxEntertainment;
		
		$this->db->where('survey_id',$hdnSurveyId);
		$this->db->update('aids_recomendation_tb',$data);
	}
	function update_medicalaid()
	{
		extract($_POST);

//		$data['survey_id'] 		  = $hdnSurveyId;
		$data['medical_aid_type_id'] = $drpMedicalaidtype;
		
		$this->db->where('survey_id',$hdnSurveyId);
		$this->db->update('medical_aid_recomendation_tb',$data);	
		
		
	}

	function update_homeaid()
	{
		extract($_POST);

		//$data['survey_id'] 		  = $hdnSurveyId;
		$data['improvement_type_id'] = $drpImprovementtype;
		
$this->db->where('survey_id',$hdnSurveyId);
		$this->db->update('home_improvement_recomendation_tb',$data);	
				
		
	}
//****************get data
function get_medicalaid_by_survey_id($surveyid)
{
	$myquery = "	SELECT	medical_aid_recomendation_id,medical_aid_type_id,medication.sub_constant_name medicalaid_type
					FROM 	medical_aid_recomendation_tb,sub_constant_tb medication
					WHERE   medical_aid_type_id      = medication.sub_constant_id	
					AND     survey_id = ".$surveyid;
		
		$res = $this->db->query($myquery);
		return $res->result();
		
}
//**************delete medical aid
function delete_medicalaid()
	{
		extract($_POST);
		
		$this->db->where('medical_aid_recomendation_id',$medicalaidId);
		$this->db->delete('medical_aid_recomendation_tb');
	}
	
function get_homeaid_by_survey_id($surveyid)
{
	$myquery = "	SELECT	home_improvement_recomendation_id,improvement_type_id,homeaid.sub_constant_name homeaid_type
					FROM 	home_improvement_recomendation_tb,sub_constant_tb homeaid
					WHERE   improvement_type_id = homeaid.sub_constant_id	
					AND     survey_id = ".$surveyid;
		
		$res = $this->db->query($myquery);
		return $res->result();
		
}
//**************delete medical aid
function delete_homeaid()
	{
		extract($_POST);
		
		$this->db->where('home_improvement_recomendation_id',$homeaidId);
		$this->db->delete('home_improvement_recomendation_tb');
	}
	
	
}
?>