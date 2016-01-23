<?php

class Surveymodel extends CI_Model
{
	

/*************************** ELDER TAB ********************************/
/*	Insert Elder									  				  */
/*	Update Elder									  				  */
/**********************************************************************/
	// Insert Elder
	function insert_elder()
	{
		extract($_POST);

		$data['elder_id'] 	  		= $txtElderId;
		$data['elder_category_id'] 	= $drpEldercategory;
		$data['first_name'] 		= $txtFname;
		$data['middle_name'] 		= $txtMname;
		$data['third_name'] 		= $txtThname;
		$data['last_name'] 			= $txtLname;
		$data['dob'] 				= $dpDob;
		$data['sex_id'] 			= $rdSex;
		$data['status_id'] 			= $drpElderstatus;
		$data['governorate_id'] 	= $drpGovernorate;
		$data['region'] 			= $drpRegion;
		$data['full_address'] 		= $drpFulladdress;
		$data['address_details'] 	= $txtAddressdetails;
		$data['phone'] 				= $txtPhone;
		$data['mobile_first'] 		= $txtMobile1;
		$data['mobile_second'] 		= $txtMobile2;
		$data['education_level_id'] = $drpEducationlevel;
		
		$data['current_job_id'] 	= $drpCurrentjob;
		$data['previous_job_id'] 	= $drpPreviousjob;
		$data['insurance_type_id'] 	= $drpInsurence;
		
		if ( $drpSpecialization == '')
			$data['specialization_id'] 	= NULL;
		
		$this->db->insert('elder_tb',$data);
		
		// Insert file_tb
		$filedata['elder_id'] = $txtElderId;
		$filedata['file_doc_id'] = $txtFiledocId;
		$filedata['file_status_id'] = 170;
		//$filedata['created_by'] = $_SESSION['username'];
		
		$this->db->insert('file_tb',$filedata);
		$file_id = $this->db->insert_id();
		
		
		// Insert survey_tb
		$surveydata['file_id'] = $file_id;
		//$surveydata['created_by'] = $_SESSION['username'];
		
		$this->db->insert('survey_tb',$surveydata);
		$survey_id = $this->db->insert_id();
		
		
		
		// Insert survey_elder_info_tb
		$data['survey_id'] = $survey_id;
		$this->db->insert('survey_elder_info_tb',$data);
		
		
		
		$outdata['file_id']   = $file_id;
		$outdata['survey_id'] = $survey_id;
		return $outdata;
		
	}
	
	// Update Elder
	function update_elder()
	{
		extract($_POST);

		$data['elder_category_id'] 	= $drpEldercategory;
		$data['first_name'] 		= $txtFname;
		$data['middle_name'] 		= $txtMname;
		$data['third_name'] 		= $txtThname;
		$data['last_name'] 			= $txtLname;
		$data['dob'] 				= $dpDob;
		$data['sex_id'] 			= $rdSex;
		$data['status_id'] 			= $drpElderstatus;
		$data['governorate_id'] 	= $drpGovernorate;
		$data['region'] 			= $drpRegion;
		$data['full_address'] 		= $drpFulladdress;
		$data['address_details'] 	= $txtAddressdetails;
		$data['phone'] 				= $txtPhone;
		$data['mobile_first'] 		= $txtMobile1;
		$data['mobile_second'] 		= $txtMobile2;
		$data['education_level_id'] = $drpEducationlevel;
		$data['specialization_id'] 	= $drpSpecialization;
		$data['current_job_id'] 	= $drpCurrentjob;
		$data['previous_job_id'] 	= $drpPreviousjob;
		$data['insurance_type_id']  = $drpInsurence;
		
		if ( $drpSpecialization == '')
			$data['specialization_id'] 	= NULL;
		
		if(isset($dpDeathdate))
			$data['death_date'] 		= $dpDeathdate;

		$this->db->where('elder_id',$txtElderId);
		$this->db->update('elder_tb',$data);
		
		// From Survey
		if(isset($hdnSurveyId))
		{
			
			if($hdnSurveyId != "")
			{
				$this->db->where('survey_id',$hdnSurveyId);
				$this->db->update('survey_elder_info_tb',$data);
				
				$file_id = $hdnFileId;
				$survey_id = $hdnSurveyId; 
			}
			else if($hdnSurveyId == "")
			{
				// Insert survey_tb
				$surveydata['file_id'] = $hdnFileId;
				//$surveydata['created_by'] = $_SESSION['username'];
				$this->db->insert('survey_tb',$surveydata);
				
				
				// Insert survey_elder_info_tb
				$survey_id = $this->db->insert_id();
				$data['survey_id'] = $this->db->insert_id();
				$this->db->insert('survey_elder_info_tb',$data);
				
				$file_id = $hdnFileId;
			}
			$outdata['survey_id'] = $survey_id;
			$outdata['file_id']   = $file_id;
			return $outdata;
		}
		
		return;
		
	}

//-------------------------- END ELDER TAB ----------------------------/


/*************************** Visit TAB ********************************/
/*	 												  				  */
/*	Update Survey									  				  */
/*													  				  */
/**********************************************************************/
	// Update Survey
	function update_survey()
	{
		extract($_POST);

		$data['visit_date'] = $dpVisitdate;
		$data['visit_time'] = $txtVisittime;
		$data['visit_end_time'] = $txtVisitendtime;
		$data['researcher_id']  = $drpResearcher;
		if($drpResearcherass1 =="")
			$data['researcher_assistant_fst_id'] = NULL;
		else
			$data['researcher_assistant_fst_id'] = $drpResearcherass1;
		if($drpResearcherass2 =="")
			$data['researcher_assistant_sec_id'] = NULL;
		else
			$data['researcher_assistant_sec_id'] = $drpResearcherass2;
		
		$this->db->where('survey_id',$hdnSurveyId);
		$this->db->update('survey_tb',$data);
	}
//-------------------------- END VISIT TAB ----------------------------/


/************************ FAMILY MEMBER TAB ***************************/
/*	Insert Family Member							  				  */
/*	Update Family Member							  				  */
/*	Delete Family Member							  				  */
/*	Get Family Member By Survey ID							  		  */
/**********************************************************************/

	// Insert Family Member
	function insert_familyMember()
	{
		extract($_POST);
		
		$data['survey_id'] 		  = $hdnSurveyId;
		$data['elder_id'] 		  = $txtElderId;
		$data['member_id'] 		  = $txtMemberId;
		$data['member_name'] 	  = $txtMembername;
		$data['member_sex_id'] 	  = $rdMemSex;
		$data['relationship_id']  = $drpMemRelationship;
		$data['status_id'] 		  = $drpMemStatus;
		$data['dob'] 			  = $dpMemDob;
		$data['education_level_id']  = $drpMemEdulevel;
		$data['health_status_id'] = $drpMemHealth;
		$data['job'] 			  = $txtMemjob;
		
		if($txtMemincome == '')
			$data['income_shekel'] 	  = NULL;
		
		
		$this->db->insert('family_member_tb',$data);
	}
	
	function update_familyMember()
	{
		extract($_POST);
		//$data['family_member_id'] = $txtFname;
		//$data['elder_id'] = $txtElderId;
		//$data['member_id'] = $txtMemberId;
		$data['member_name'] = $txtMembername;
		$data['member_sex_id'] = $rdMemSex;
		$data['relationship_id'] = $drpMemRelationship;
		$data['status_id'] = $drpMemStatus;
		$data['dob'] = $dpMemDob;
		$data['education_level'] = $drpMemEdulevel;
		$data['health_status_id'] = $drpMemHealth;
		$data['job'] = $txtMemjob;
		
		if($txtMemincome == '')
			$data['income_shekel'] 	  = NULL;
		
		$this->db->where('member_id',$txtMemberId);
		$this->db->update('family_member_tb',$data);
	}
	
	// Delete Family Member
	function delete_familyMember()
	{
		extract($_POST);
		
		$this->db->where('family_member_id',$familymemberid);
		$this->db->delete('family_member_tb');
	}
	
	function get_familyMember_by_survey_id($surveyid)
	{
		
		$myquery = "SELECT fm.family_member_id, fm.survey_id, fm.elder_id, fm.member_id, fm.member_name, fm.dob, fm.income_shekel, 		
						fm.job, fm.member_sex_id, sex.sub_constant_name sex,
        				fm.relationship_id, rel.sub_constant_name relationship,
        				fm.status_id, stat.sub_constant_name fmstatus,
        				fm.education_level_id, edu.sub_constant_name education_level,
        				fm.health_status_id, hlt.sub_constant_name health_status
					 FROM family_member_tb fm
					  LEFT OUTER JOIN sub_constant_tb sex  ON fm.member_sex_id      = sex.sub_constant_id
					  LEFT OUTER JOIN sub_constant_tb rel  ON fm.relationship_id    = rel.sub_constant_id
					  LEFT OUTER JOIN sub_constant_tb stat ON fm.status_id          = stat.sub_constant_id
					  LEFT OUTER JOIN sub_constant_tb edu  ON fm.education_level_id = edu.sub_constant_id
					  LEFT OUTER JOIN sub_constant_tb hlt  ON fm.health_status_id 	= hlt.sub_constant_id
				  WHERE fm.survey_id = ".$surveyid;
		
		$res = $this->db->query($myquery);
		return $res->result();
	}
	function check_familyMember_id()
	{	extract($_POST);
		$this->db->where('member_id',$member_id);
		$query = $this->db->get('family_member_tb');
		return $query->result();
		
	}
//----------------------- END FAMILY MEMBER TAB -----------------------/

/************************ ELDER HEALTH STATUS TAB *********************/
/*	Insert Elder Disease Det						  				  */
/*	Delete Elder Disease Det						  				  */
/*	Insert Elder Disease (Master Table)				  				  */
/*	Update Elder Disease (Master Table)				  				  */
/*	Get Elder Disease										  		  */
/**********************************************************************/
	function elder_disease_det_insert()
	{
		
		extract($_POST);
		
		if($hdnElderDiseaseId=='')
		{
			$masterdata['survey_id'] = $hdnSurveyId;
			
			$this->db->insert('elder_disease_tb',$masterdata);
			$hdnElderDiseaseId = $this->db->insert_id();
		}
		
		$data['elder_disease_id'] 	 = $hdnElderDiseaseId;
		$data['disease_id']  = $diseaseid;
		
		$this->db->insert('elder_disease_det_tb',$data);
		
		return $hdnElderDiseaseId;
	}
	
	function elder_disease_det_delete()
	{
		extract($_POST);
		
		$this->db->where('elder_disease_det_id',$elderdiseaseid);
		$this->db->delete('elder_disease_det_tb');
	}
	
	function elder_disease_insert()
	{
		extract($_POST);
		
		$data['survey_id'] = $hdnSurveyId;
		$data['elder_disease_details'] = $elderdiseasedet;
		
		$this->db->insert('elder_disease_tb',$data);
		
		return $this->db->insert_id();
	}
	
	function elder_disease_update()
	{
		extract($_POST);
		
		$data['elder_disease_details'] = $elderdiseasedet;
		
		$this->db->where('elder_disease_id',$hdnElderDiseaseId);
		$this->db->update('elder_disease_tb',$data);
		
	}
	
	function get_elder_disease_by_survey_id($surveyid)
	{
		
		$myquery = "SELECT  ed.elder_disease_id, ed.survey_id, ed.elder_disease_details, 
							det.elder_disease_det_id, det.disease_id, dis.sub_constant_name disease
					  FROM  elder_disease_tb ed, elder_disease_det_tb det, sub_constant_tb dis
					 WHERE  ed.elder_disease_id = det.elder_disease_id
					   AND  det.disease_id = dis.sub_constant_id
  					   AND  ed.survey_id = ".$surveyid;
		
		$res = $this->db->query($myquery);
		
		return $res->result();
		
	}
//-------------------- END ELDER HEALTH STATUS TAB ---------------------/

/************************ INCOME RESOURCE TAB *************************/
/*	Insert Income Resource (Master Table)		  			   		  */
/*	Update Income Resource (Master Table)		  				  	  */
/*	Insert Income Resourc Details					  				  */
/*	Update Income Resourc Details				  				  	  */
/*	Get Income Resourc Details								  		  */
/**********************************************************************/
	function income_resources_insert()
	{
		extract($_POST);
		
		$data['survey_id'] 			= $hdnSurveyId;
		if (isset($txtTotalincome) && $txtTotalincome != "")
			$data['total_income'] 	= $txtTotalincome;
		else
			$data['total_income'] 	= NULL;
		if (isset($txtElderportion) && $txtElderportion != "")
			$data['elder_portion'] 	= $txtElderportion;
		else
			$data['elder_portion'] 	= NULL;
		
		$this->db->insert('income_resources_tb',$data);
		 
		return $this->db->insert_id();
		 
	}
	function income_resources_update()
	{
		extract($_POST);
		
		$data['total_income'] 	= $txtTotalincome;
		$data['elder_portion'] 	= $txtElderportion;
		
		$this->db->where('survey_id',$hdnSurveyId);
		$this->db->update('income_resources_tb',$data);
		
	}
	function income_resources_details_insert()
	{
		extract($_POST);
		
		if ($hdnIncomeResourcesId == "")
			$hdnIncomeResourcesId = $this->income_resources_insert();
			
		$data['income_resources_id']  = $hdnIncomeResourcesId;
		$data['resource_id'] 		  = $drpIncomeSource;
		
		if ( $drpOrganization != "" )
			$data['organization_id']  = $drpOrganization;
		else
			$data['organization_id']  = NULL;
		
		if ( $txtCashincome != "" )
			$data['cash_income']  = $txtCashincome;
		else
			$data['cash_income']  = NULL;
		
		if ( $txtPackageincome != "" )
			$data['package_income']  = $txtPackageincome;
		else
			$data['package_income']  = NULL;
		
		if ( $txtPackagecashvalue != "" )
			$data['package_cash_value']  = $txtPackagecashvalue;
		else
			$data['package_cash_value']  = NULL;
		
		
		$this->db->insert('income_resources_details_tb',$data);
		
		return $hdnIncomeResourcesId;
		 
	}
	function income_resources_details_delete()
	{
		extract($_POST);
		
		$this->db->where('income_resources_details_id', $incomeresourcedetid);
		$this->db->delete('income_resources_details_tb');
	}
	function get_income_resources_details($surveyid)
	{
		$myquery = "SELECT ird.income_resources_details_id, ird.income_resources_id, ird.cash_income,
						   ird.package_income, ird.package_cash_value,
						   ird.resource_id, res.sub_constant_name resource,
						   ird.organization_id, org.sub_constant_name organization
					  FROM income_resources_tb ir, sub_constant_tb res, income_resources_details_tb ird
						LEFT OUTER JOIN sub_constant_tb org ON ird.organization_id = org.sub_constant_id
					 WHERE ir.income_resources_id =  ird.income_resources_id
					   AND ird.resource_id = res.sub_constant_id
   					   AND ir.survey_id = ".$surveyid."
				  ORDER BY ird.resource_id";
		
		$res = $this->db->query($myquery);
		
		return $res->result();
	}

//--------------------- END INCOME RESOURCES TAB ----------------------/

/************************ FAMILY HOME STATUS TAB **********************/
/*	Insert Home Status								  				  */
/*	Update Home Status								  				  */
/**********************************************************************/

	function insert_homeStatus()
	{
		extract($_POST);

		$data['survey_id'] 		    	= $hdnSurveyId;
		$data['home_situation_id']  	= $drpHomeStatus;
		$data['home_type_id'] 	    	= $drpHomeType;
		$data['ceiling_type_id']    	= $drpCeilingType;
		$data['ceiling_description']    = $txtCeilingdescription;
		$data['furniture_level_id'] 	= $drpFurnitureLevel;
		$data['furniture_needs'] 		= $txtarFurnitureneeds;
			
		$this->db->insert('home_status_tb ',$data);
		
		return $this->db->insert_id();
		
	}
	
	function update_homeStatus()
	{
		extract($_POST);

		$data['home_situation_id']  	= $drpHomeStatus;
		$data['home_type_id'] 	    	= $drpHomeType;
		$data['ceiling_type_id']    	= $drpCeilingType;
		$data['ceiling_description']    = $txtCeilingdescription;
		$data['furniture_level_id'] 	= $drpFurnitureLevel;
		$data['furniture_needs'] 		= $txtarFurnitureneeds;
		
			
		$this->db->where('home_status_id',$hdnHomeStatusId);
		$this->db->update('home_status_tb ',$data);
		
	}
//-------------------- END FAMILY HOME STATUS TAB ---------------------/

/************************ ELDER ROOM STATUS TAB ***********************/
/*	Insert Elder Room								  				  */
/*	Update Elder Room								  				  */
/**********************************************************************/

	function insert_elderRoom()
	{
		extract($_POST);

		$data['survey_id'] 		    		= $hdnSurveyId;
		$data['home_type_id'] 				= $drpElderHometype;
		$data['room_type_id'] 				= $drpRoomtype;
		$data['clothes_covers_status_id'] 	= $drpClothes;
		$data['room_ventilation_id'] 		= $drpVentilation;
		$data['room_lighting_id'] 			= $drpLighting;
		$data['has_closet'] 				= $drpCloset;
		$data['has_good_bed'] 				= $drpBed;
		$data['has_medicine_cupboard'] 		= $drpCupboard;
		$data['room_need_maintenance'] 		= $drpMaintenance;
		$data['room_maintenance_details'] 		= $txtarRoommaintinancedet;
		$data['bathroom_status_id'] 			= $drpBathroom;
		$data['bathroom_maintenance_details'] 	= $txtarBathroommaintinancedet;
		$data['elder_higiene_id'] 				= $drpHigiene;
		
			
		$this->db->insert('elder_room_tb ',$data);
		
		return $this->db->insert_id();
		
	}
	function update_elderRoom()
	{
		extract($_POST);
		
		$data['home_type_id'] 				= $drpElderHometype;
		$data['room_type_id'] 				= $drpRoomtype;
		$data['clothes_covers_status_id'] 	= $drpClothes;
		$data['room_ventilation_id'] 		= $drpVentilation;
		$data['room_lighting_id'] 			= $drpLighting;
		$data['has_closet'] 				= $drpCloset;
		$data['has_good_bed'] 				= $drpBed;
		$data['has_medicine_cupboard'] 		= $drpCupboard;
		$data['room_need_maintenance'] 		= $drpMaintenance;
		$data['room_maintenance_details'] 		= $txtarRoommaintinancedet;
		$data['bathroom_status_id'] 			= $drpBathroom;
		$data['bathroom_maintenance_details'] 	= $txtarBathroommaintinancedet;
		$data['elder_higiene_id'] 				= $drpHigiene;
		
			
		$this->db->where('elder_room_id',$hdnElderRoomId);
		$this->db->update('elder_room_tb ',$data);
		
	}


//---------------------- END ELDER ROOM STATUS TAB ---------------------/

/************************ ELDER MEDICATION TAB ***********************/
/*	Insert Medication Availability					  				  */
/*	Delete Medication Availability					  				  */
/*	Get Medication Availability					  					  */
/*	Insert Medication Need							  				  */
/*	Delete Medication Need							  				  */
/*	Get Medication Need								  				  */
/**********************************************************************/
	function medication_availability_insert()
	{
		extract($_POST);

		$data['survey_id'] 		    		= $hdnSurveyId;
		$data['medicine_name'] 				= $txtMedicinename;
		$data['availability_status_id'] 	= $drpMedicationAvailable;
		$data['unavailable_reason'] 		= $txtReason;		
			
		$this->db->insert('medication_availability_tb ',$data);
		
		return $this->db->insert_id();
	}
	function medication_availability_delete()
	{
		extract($_POST);
		
		$this->db->where('medication_availability_id',$medicationavaid);
		$this->db->delete('medication_availability_tb');
	}
	function get_medication_availability($surveyid)
	{
		$myquery = "SELECT ma.medication_availability_id, ma.survey_id, ma.medicine_name,
	   						ma.availability_status_id, avstat.sub_constant_name availability_status, ma.unavailable_reason
					  FROM  medication_availability_tb ma, sub_constant_tb avstat
					 WHERE  ma.availability_status_id = avstat.sub_constant_id
  					   AND  ma.survey_id = ".$surveyid;
		
		$res = $this->db->query($myquery);
		
		return $res->result();
	}
	
	function medication_need_insert()
	{
		extract($_POST);

		$data['survey_id'] 		    	= $hdnSurveyId;
		$data['medication_type_id'] 	= $drpMedtype;
		$data['medication_details'] 	= $txtMeddetails;
		
			
		$this->db->insert('medication_need_tb ',$data);
		
		return $this->db->insert_id();
	}
	function medication_need_delete()
	{
		extract($_POST);
		
		$this->db->where('medication_need_id',$medicationneedid);
		$this->db->delete('medication_need_tb');
	}
	function get_medication_need($surveyid)
	{
		$myquery = "SELECT  mn.medication_need_id, mn.survey_id, mn.medication_type_id, typ.sub_constant_name medication_type,
							mn.medication_details
					  FROM	medication_need_tb mn, sub_constant_tb typ
					 WHERE  mn.medication_type_id = typ.sub_constant_id
  					   AND  mn.survey_id = ".$surveyid;
		
		$res = $this->db->query($myquery);
		
		return $res->result();
	}
//-------------------- END ELDER MEDICATION STATUS TAB -------------------/

/********************* ELDER FAMILY RELATIONSHIP TAB *********************/
/*	Insert Family Relationship		   				  				     */
/*	Update Family Relationship						  				 	 */
/*************************************************************************/
	function insert_elderFamilyRelation()
	{
		extract($_POST);

		$data['survey_id'] 		 	   		   = $hdnSurveyId;
		$data['respect'] 		 	   		   = $drpRespect;
		$data['pariah'] 		       		   = $drpPariah;
		$data['care'] 			 	   		   = $drpCare;
		$data['psychological_support'] 		   = $drpPsycosupport;
		$data['provision_needs'] 	   		   = $drpNeeds;
		$data['no_provision_needs_reason'] 	   = $txtarNeedreasone;
		$data['legal_advice'] 	   			   = $drpLegaladvice;
		$data['legal_advice_reason'] 	   	   = $txtarLegaladvicereasone;
		
			
		$this->db->insert('family_elder_relationship_tb',$data);
		
		
	}
	function update_elderFamilyRelation()
	{
		extract($_POST);

		$data['respect'] 		 	   		   = $drpRespect;
		$data['pariah'] 		       		   = $drpPariah;
		$data['care'] 			 	   		   = $drpCare;
		$data['psychological_support'] 		   = $drpPsycosupport;
		$data['provision_needs'] 	   		   = $drpNeeds;
		$data['no_provision_needs_reason'] 	   = $txtarNeedreasone;
		$data['legal_advice'] 	   			   = $drpLegaladvice;
		$data['legal_advice_reason'] 	   	   = $txtarLegaladvicereasone;
			
		$this->db->where('survey_id',$hdnSurveyId);
		$this->db->update('family_elder_relationship_tb ',$data);
		
	}
//------------------- END ELDER FAMILY RELATIONSHIP TAB -------------------/

/************************** ELDER BEHAVIOUR TAB **************************/
/*	Insert Elder Behaviour 							  				     */
/*	Update Elder Behaviour							  				 	 */
/*	Get Elder Behaviour							  				 	 	 */
/*	Insert Elder Pariah 							  				     */
/*	Update Elder Pariah								  				 	 */
/*	Get Elder Pariah							  				 	 	 */
/*************************************************************************/
	function elder_behaviour_insert()
	{
		extract($_POST);

		$data['survey_id'] 		= $hdnSurveyId;
		$data['behaviour_id']  = $drpBehaviour;
		
			
		$this->db->insert('elder_behaviour_tb',$data);
	}
	function elder_behaviour_delete()
	{
		extract($_POST);
		
		if ($behaviourid == 211)
		{
			$this->elder_pariah_delete_all();
		}
		
		$this->db->where('elder_behaviour_id',$elderbehaviourid);
		$this->db->delete('elder_behaviour_tb ');
	}
	function get_elder_behaviour($surveyid)
	{
		$myquery = "SELECT eb.elder_behaviour_id, eb.survey_id, eb.behaviour_id, bhv.sub_constant_name behaviour
					  FROM elder_behaviour_tb eb, sub_constant_tb bhv
					 WHERE eb.behaviour_id = bhv.sub_constant_id
  					   AND eb.survey_id = ".$surveyid;
		
		$res = $this->db->query($myquery);
		
		return $res->result();
	}
	function elder_pariah_insert()
	{
		extract($_POST);

		$data['survey_id'] 		= $hdnSurveyId;
		$data['elder_pariah_reason_id']  = $drpPariahreasone;
		
			
		$this->db->insert('elder_pariah_tb',$data);
	}
	function elder_pariah_delete()
	{
		extract($_POST);
		
		
		$this->db->where('elder_pariah_id',$elderpariahid);
		$this->db->delete('elder_pariah_tb ');
	}
	function elder_pariah_delete_all()
	{
		extract($_POST);
		
		$this->db->where('survey_id',$hdnSurveyId);
		$this->db->delete('elder_pariah_tb ');
	}
	function get_elder_pariah($surveyid)
	{
		$myquery = "SELECT ep.elder_pariah_id, ep.survey_id, ep.elder_pariah_reason_id, prh.sub_constant_name pariah_reason
					  FROM elder_pariah_tb ep, sub_constant_tb prh
					 WHERE ep.elder_pariah_reason_id = prh.sub_constant_id
  					   AND ep.survey_id = ".$surveyid;
		
		$res = $this->db->query($myquery);
		
		return $res->result();
	}
//--------------------- END ELDER BEHAVIOUR TAB --------------------------/

/******************* FAMILY PSYCHOLOGICAL STATUS TAB *********************/
/*	Insert Family Psychological Status				  				     */
/*	Update Family Psychological Status				  				 	 */
/*	Get Family Psychological Status				  				 	 	 */
/*************************************************************************/
	function family_psychological_status_insert()
	{
		extract($_POST);

		$data['survey_id'] 		 	   	   = $hdnSurveyId;
		$data['psychological_status_id']   = $drpPsychologicalStatus;
		
			
		$this->db->insert('family_psychological_status_tb',$data);
	}
	
	function family_psychological_status_delete()
	{
		extract($_POST);
		
		$this->db->where('family_psychological_status_id',$familypsychoid);
		$this->db->delete('family_psychological_status_tb ');
	}
	function get_family_psychological_status($surveyid)
	{
		$myquery = "SELECT fp.family_psychological_status_id, fp.survey_id, 
						   fp.psychological_status_id, psy.sub_constant_name psychological_status
					  FROM family_psychological_status_tb fp, sub_constant_tb psy
					 WHERE fp.psychological_status_id = psy.sub_constant_id
  					   AND fp.survey_id = ".$surveyid;
		
		$res = $this->db->query($myquery);
		
		return $res->result();
	}
//----------------- END FAMILY PSYCHOLOGICAL STATUS TAB -------------------/

/************************** LIFE IMPROVEMENT TAB *************************/
/*	Insert Life Improvement							  				     */
/*	Update Life Improvement							  				 	 */
/*************************************************************************/

	function insert_lifeImprovement()
	{
		extract($_POST);

		$data['survey_id'] 				= $hdnSurveyId;
		$data['elder_work_ability_id'] 	= $drpElderWorkAbility;
		$data['elder_work_type'] 		= $txtelderworktype;
		$data['family_work_type'] 		= $txtFamilyworktype;
		$data['is_elder_need_training'] = $drpNeedtraining;
		$data['elder_training_type'] 	= $txtTrainigType;
		$data['can_start_project'] 		= $drpStartproject;
		$data['project_type'] 			= $txtProjectType;
		
		if($drpFamilyMember != '')
			$data['family_member_id'] 		= $drpFamilyMember;
		else
			$data['family_member_id'] 		= NULL;
		
		if ($txtProjectBudget != '')
			$data['project_budget'] 		= $txtProjectBudget;
		else
			$data['project_budget'] 		= NULL;
		
			
		$this->db->insert('life_improvement_tb',$data);
		
	}
	function update_lifeImprovement()
	{
		extract($_POST);

		$data['elder_work_ability_id'] 	= $drpElderWorkAbility;
		$data['elder_work_type'] 		= $txtelderworktype;
		$data['family_work_type'] 		= $txtFamilyworktype;
		$data['is_elder_need_training'] = $drpNeedtraining;
		$data['elder_training_type'] 	= $txtTrainigType;
		$data['can_start_project'] 		= $drpStartproject;
		$data['project_type'] 			= $txtProjectType;
		
		if($drpFamilyMember != '')
			$data['family_member_id'] 		= $drpFamilyMember;
		else
			$data['family_member_id'] 		= NULL;
		
		if ($txtProjectBudget != '')
			$data['project_budget'] 		= $txtProjectBudget;
		else
			$data['project_budget'] 		= NULL;
			
			
		$this->db->where('survey_id',$hdnSurveyId);
		$this->db->update('life_improvement_tb ',$data);
		
	}
//*******************Cooperative Family**************//


	function insert_cooperFamily()
	{
		extract($_POST);

		$data['survey_id'] 					 = $hdnSurveyId;
		$data['is_cooperative_family'] 		 = $drpIScooperative;
		$data['cooperative_persone_type_id'] = $drpcooperPersonetype;
		$data['cooperative_persone_id'] 	 = $txtcooperPersoneId;
		$data['cooperative_persone_name']    = $txtcooperPersoneName;
		$data['cooperative_persone_mobile']  = $txtcooperPersoneMobile;
		$data['cooperative_persone_address'] = $txtcooperPersoneAddress;
		
		$this->db->insert('family_cooperation_tb',$data);
		
	}
	function update_cooperFamily()
	{
		extract($_POST);

		
		$data['is_cooperative_family'] 		 = $drpIScooperative;
		$data['cooperative_persone_type_id'] = $drpcooperPersonetype;
		$data['cooperative_persone_id'] 	 = $txtcooperPersoneId;
		$data['cooperative_persone_name']    = $txtcooperPersoneName;
		$data['cooperative_persone_mobile']  = $txtcooperPersoneMobile;
		$data['cooperative_persone_address'] = $txtcooperPersoneAddress;
					
		$this->db->where('survey_id',$hdnSurveyId);
		$this->db->update('family_cooperation_tb ',$data);
		
	}
//*******************End Cooperative Family**********//	
//--------------------- END LIFE IMPROVEMENT TAB -----------------------/	
	function insert_survey()
	{
		extract($_POST);

		$data['file_id'] = $txtFileid;
		$data['visit_date'] = $dpVisitdate;
		$data['visit_time'] = $txtVisittime;
		$data['visit_end_time'] = $txtVisitendtime;
		$data['researcher_id'] = $drpResearcher;
		$data['researcher_assistant_fst_id'] = $drpResearcherass1;
		$data['researcher_assistant_sec_id'] = $drpResearcherass2;
			
		$this->db->insert('survey_tb',$data);
		$Surveyid=$this->db->insert_id();
		return $Surveyid;
	}



function get_region_list()
	{	extract($_POST);
		$this->db->where('parent_id',$governorateCode);
		$query = $this->db->get('sub_constant_tb ');
		return $query->result();
		
	}
function get_fulladress_list()
	{	extract($_POST);
		$this->db->where('parent_id',$regionCode);
		$query = $this->db->get('sub_constant_tb ');
		return $query->result();
		
	}

function get_survey_info()
	{	extract($_POST);
		$this->db->where('file_id',$file_id);
		$query = $this->db->get('survey_tb');
		return $query->result();
		
	}

//***********************end family_member_tb operations*********************
//**********************Home_status operation********************************

function get_homeStatus_info()
	{	extract($_POST);
		$this->db->where('survey_id',$SurveyId);
		$query = $this->db->get('home_status_tb');
		return $query->result();
		
	}

//*********************end home_status operation*****************************

//**********************Home_status operation********************************
//*************** elder family relation*****************//

//********************end elder family relation function**************//

//**********************elder life improvement function********************************//

//********************Recomndtion function**************//

	function insert_aidrecomend()
	{
		extract($_POST);

		$data['survey_id'] 				= $hdnSurveyId;
		
		if ($drpCashaidtype != "")
			$data['cash_aid_type_id'] 	= $drpCashaidtype;
		$data['cash_aid_amount'] 		= $txtCashaidamount;
		
		if ($drpNutritiontype != "")
			$data['nutrition_type_id'] 	= $drpNutritiontype;
		$data['nutrition_details'] 		= $txtNutritiondetails;
		
		$data['psychological_support'] 	= $txtarPsychologicalsupport;
		$data['social_support'] 		= $txtarSocialsupport;
		$data['entertainment'] 			= $txtarEntertainment;
		
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

		$data['survey_id'] 		  	 = $hdnSurveyId;
		$data['improvement_type_id'] = $drpImprovementtype;
		$data['improvement_details'] = $txtImprovementdet;
		
		$this->db->insert('home_improvement_recomendation_tb',$data);
		
	}
//*******************updates*****************//
	function update_aidrecomend()
	{
		extract($_POST);

		$data['survey_id'] 		  		= $hdnSurveyId;
		$data['cash_aid_type_id'] 		= $drpCashaidtype;
		$data['cash_aid_amount'] 		= $txtCashaidamount;
		$data['nutrition_type_id'] 		= $drpNutritiontype;
		$data['nutrition_details'] 		= $txtNutritiondetails;
		$data['psychological_support'] 	= $txtarPsychologicalsupport;
		$data['social_support'] 		= $txtarSocialsupport;
		$data['entertainment'] 			= $txtarEntertainment;
		
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
	$myquery = "	SELECT	home_improvement_recomendation_id, improvement_type_id, homeaid.sub_constant_name homeaid_type,
							improvement_details
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
	
	
//***************************************************//
}
?>