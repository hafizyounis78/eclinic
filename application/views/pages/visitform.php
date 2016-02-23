<!-- END PAGE HEADER-->
<!-- BEGIN PAGE CONTENT-->
<?php
$ction ="addvisit";
$Laction="";
$Paction="addPlanVisit";
$page_title = "إضافة زيارة";
$readonly = '';
$disabled = '';
date_default_timezone_set('Asia/Gaza');
$currentDate= date("Y-m-d"); 
$lblClass = ' font-green ';
$lblage = '';


if (isset($patient_info))				
{
	foreach($patient_info as $patient_row);
	$page_title = "إضافة زيارة";
	$ction ="addvisit";
	date_default_timezone_set('Asia/Gaza');   
		//date in yyyy-mm-dd format;
		if (isset($visit_row->dob))
		{
  			$birthDate = $patient_row->dob;
			//explode the date to get month, day and year
			$birthDate = explode("-", $birthDate);
			//get age from date or birthdate
			$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[2], $birthDate[1], $birthDate[0]))) > date("md")
		  	? ((date("Y") - $birthDate[0]) - 1)
		  	: (date("Y") - $birthDate[0]));
		
			if ($age > 60 )
				$lblClass = ' font-green ';
			else
				$lblClass = ' font-red ';
			
				$lblage = '<b> المريض العضو : <span id="spnAge">'.$age.'</span></b>';
		}	


}
if(isset($visit_info))
{
	foreach($visit_info as $visit_row);

		if (isset($visit_row->visit_date))				
		{	
			$ction ="updatevisit";
			$page_title = "تعـــديل زيارة";
			$readonly = 'readonly="readonly"';
			$disabled = 'disabled="disabled" ';
		}
}
$plan_table = "";
$plan_id = "";
$model_num = "";
$outpatientnutritionId = "";
$startdate= "";
$enddate= "";
$notes = "";
if (isset($plan_info))				
{
	if (isset($row->plan_id))
	{

		$days = array( 
				1 => 'اليوم الأول',
				2 => 'اليوم الثاني',
				3 => 'اليوم الثالث', 
				4 => 'اليوم الرابع',
				5 => 'اليوم الخامس',
				6 => 'اليوم السادس',
				7 => 'اليوم السابع');
			
		$plan_table = '<table class="table table-striped table-hover table-bordered" id="accordion2">
				<thead>
				  <tr class="bg-grey-steel">
					  <th scope="col">
						   &nbsp;
					  </th>
					  <th scope="col">
						الفـطــــور
					  </th>
					  <th scope="col">
						الغـــــداء
					  </th>
					  <th scope="col">
						العشـــــاء
					  </th>
				  </tr>
				</thead>
				<tbody>';
			foreach($plan_info as $row)
			{
				
				$plan_table = $plan_table.
						'<tr>
						  <td>'.$days[$row->plan_day_id].'</td>
						  <td>
							<textarea name="txtbreakfast'.$row->plan_day_id.'" id="txtbreakfast'.$row->plan_day_id.'" cols="70" rows="5" class="form-control">'.$row->breakfast.'</textarea></td>
						<td>
							<textarea name="txtlunch'.$row->plan_day_id.'" id="txtlunch'.$row->plan_day_id.'" cols="70" rows="5" class="form-control">'.$row->lunch.'</textarea></td>
						<td>
							<textarea name="txtdinner'.$row->plan_day_id.'" id="txtdinner'.$row->plan_day_id.'" cols="70" rows="5" class="form-control">'.$row->dinner.'</textarea></td>
					 </tr>';
		
			}
			$plan_table = $plan_table.' </tbody>
			</table>';
	
		
			$plan_id = $row->plan_id;
			$model_num = $row->model_num;
			$outpatientnutritionId = $row->outpatientnutrition_id;
			$startdate= $row->start_date;
			$enddate= $row->end_date;
			$notes = $row->notes;
			$Paction="updatePlanVisit";
		}
}
$bmi_table = "";
if (isset($bmi_history))
{
	$header = "";
	$body   = "";
	foreach($bmi_history as $bmi_row)
	{
		$header = $header.'<th scope="col">'.$bmi_row->visit_date.'</th>';
		$body   = $body.'<td>'.$bmi_row->bmi.'</td>';
	}
	if(count($bmi_history) > 0)
	{
		$bmi_table = '<table class="table table-striped table-hover table-bordered" id="accordion2">
						<thead>
						<tr class="bg-grey-steel">'.$header.'</tr></thead>
						<tbody><tr>'.$body.'</tr></tbody>
        			 </table>';
		
	}
}
?>

<!-- END PAGE HEADER-->
<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
  
       <div class="portlet box blue-madison">
          <div class="portlet-title">
              <div class="caption">
                  <i class="fa fa-gift"></i>زيــــارة المريـــــض 
              </div>
          </div>          
          <div class="portlet-body">
              <div class="panel-group accordion" id="accordion1">
                  <div class="panel panel-default">
                      <div class="panel-heading">
                          <h4 class="panel-title">
                          <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse_1">
                          <strong>#1 بيـانات الزيــارة</strong> </a>
                          </h4>
                      </div>
                      <div id="collapse_1" class="panel-collapse collapse"><!--class="panel-collapse in-->
                          <div class="panel-body">
                              <div class="portlet-body form">
                                <!-- BEGIN FORM-->
                                <form action="#" id="Visit_form" class="form-horizontal">
                                <div class="form-body">
                                  <br/>
                                    <div class="alert alert-danger display-hide">
                                        <button  class="close" data-close="alert"></button>
                                        <span id="spnMsg">
                                        يـوجد بـعـض الادخـالات الخـاطئة، الرجـاء التأكد من القيم المدخلة
                                        </span>
                                    </div>
                                    <div class="alert alert-success display-hide">
                                        <button class="close" data-close="alert"></button>
                                          تـم عملية حـفـظ البيـانات بنجـاح !
                                    </div>
                                    <div>
                                    <input id="hdnvAction" name="hdnvAction" type="hidden" value="<?php echo $ction;?>" />
                                    <input id="hdnvisitNo" name="hdnvisitNo" type="hidden" value="<?php if(isset($visit_row->outpatient_visit_id)) echo $visit_row->outpatient_visit_id;?>" />
                                    </div>
                                                         
                                    <div class="form-group">
                                        <label class="control-label col-md-3">رقم السجل الطبي  <span class="required">
                                        * </span>
                                        </label>
                                        <div class="col-md-1">
                                            <input type="text" id="txtPatientFileId" name="txtPatientFileId" data-required="1" class="form-control input-xsmall"  readonly="readonly" value="<?php if(isset($patient_row->patient_file_id)) echo $patient_row->patient_file_id; else if(isset($visit_row->patient_file_id)) echo $visit_row->patient_file_id;?>"/>
                                        </div>
                                        <div class="col-md-3">
                                         <input type="text" id="txtpatientName" name="txtpatientName" data-required="1" class="form-control" placeholder="الاسم" readonly="readonly" value="<?php if(isset($patient_row->name)) echo $patient_row->name;else if(isset($visit_row->name)) echo $visit_row->name;?>"/>
                                      </div>
                                    </div>
                                                         
                                    <div class="form-group">
                                        <label class="control-label col-md-3">تـاريخ الميـلاد <span class="required">
                                        * </span>
                                        </label>
                                        <div class="col-md-4">
                                            <div class="input-group date date-picker" data-date-format="yyyy-mm-dd">
                                                <input type="text" class="form-control" readonly id="dpDob" name="dpDob"
                                                value="<?php if(isset($patient_row->dob)) echo $patient_row->dob;else if(isset($visit_row->dob)) echo $visit_row->dob;?>"
                                               onchange="claculateAge();" >
                                                <span class="input-group-btn">
                                                <button class="btn default" <?php echo $disabled ;?> type="button"><i class="fa fa-calendar"></i></button>
                                                </span>
                                            </div>
                                            <!-- /input-group -->
                                        </div>
                                        <div class="col-md-4">
                                             <label id="lblAge" class="control-label" <?php echo $lblClass?>>
                                              <?php echo $lblage;?></label>
                                        </div>
                                    </div>
                                                                    
                                    <div class="form-group">
                                          <label class="control-label col-md-3">تـاريخ  الزيارة <span class="required">
                                          * </span>
                                          </label>
                                          <div class="col-md-2">
                                            <div class="input-group date date-picker" data-date-format="yyyy-mm-dd">
                                                <input type="text" class="form-control" readonly id="dpVisitdate" name="dpVisitdate" value="<?php if(isset($visit_row->visit_date)) echo $visit_row->visit_date; else echo $currentDate; ?>">
                                                <span class="input-group-btn">
                                                <button class="btn default" <?php echo $disabled ;?> type="button"><i class="fa fa-calendar"></i></button>
                                                </span>
                                            </div>
                                            <!-- /input-group -->
                                        </div>
                                        <div class="col-md-2">
                                              <div class="input-group">
                                                  <input type="text" id="txtVisittime" name="txtVisittime"  value="" <?php echo $readonly ;?>
                                                  class="form-control timepicker timepicker-24" >
                                                  <span class="input-group-btn">
                                                  <button class="btn default"   type="button" <?php echo $disabled ;?>><i class="fa fa-clock-o"></i></button>
                                                  </span>
                                              </div> 
                                          </div>
                                          <div class="col-md-2">
                                            <label class="control-label">&nbsp;&nbsp;&nbsp;نـــوع الـــزيارة &nbsp;&nbsp; <span class="required">
                                        * </span>
                                        </label>
                                        </div>
                                        <div class="col-md-2">
                                            <select class="form-control " id="drpVisitType" name="drpVisitType">
                                                <option value="">اختر...</option>
                                                <?php 
                                                foreach ($visittype as $row)
                                                {
                                                    $selected = '';
                                                    
                                                    if ($visit_row->visit_type_id == $row->sub_constant_id)
                                                      $selected = 'selected="selected"';
                                                    echo ' <option value="'.$row->sub_constant_id.'"'.$selected.' >'
                                                                           .$row->sub_constant_name.'</option>';
                                                }
                                                ?>
                                            </select>
                                        
                                    </div>
                                      </div>
                                      
                                                                   
                                    <div class="form-group">
                                        <label class="control-label col-md-3">الوزن &nbsp;&nbsp;&nbsp;
                                        </label>
                                        <div class="col-md-4">
                                            <input type="text" id="txtWeight" name="txtWeight" class="form-control"
                                             value="<?php if(isset($visit_row->weight)) echo $visit_row->weight;?>" onblur="calculat_bmi();"
                                            />
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="control-label col-md-3">الطول   &nbsp;&nbsp;&nbsp;
                                        </label>
                                        <div class="col-md-4">
                                            <input type="text" id="txtLength" name="txtLength" class="form-control"
                                            value="<?php if(isset($visit_row->length)) echo $visit_row->length;?>" onblur="calculat_bmi();"
                                            />
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="form-group">
                                        <label class="control-label col-md-3"> BMI   &nbsp;&nbsp;&nbsp;
                                        </label>
                                        <div class="col-md-4">
                                            <input type="text" id="txtBmi" name="txtBmi"  readonly class="form-control"
                                            value="<?php if(isset($visit_row->bmi)) echo $visit_row->bmi;?>"
                                            />
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="control-label col-md-3"> BMI History  &nbsp;&nbsp;&nbsp;
                                        </label>
                                        <div class="col-md-4">
                                            <?php if(isset($bmi_table)) echo $bmi_table;?>
                                        </div>
                                    </div>
                                  </div>
                                <!-- END FORM BODY -->
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="submit" class="btn blue-madison">حـفـظ</button>
                                            <button type="button" class="btn default" 
                                            onclick="window.location='<?php echo base_url()?>patientcont/patientlist';">عودة</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                                <!-- END FORM-->
                            </div>
                          </div> <!-- END panel-body -->
                      </div>
                  </div>
                  <div class="panel panel-default">
                      <div class="panel-heading">
                          <h4 class="panel-title">
                          <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse_2">
                          <strong>#2 فحــوصـات المختــبر</strong>  </a>
                          </h4>
                      </div>
                      <div id="collapse_2" class="panel-collapse collapse">
                          <div class="panel-body">
                              <div class="portlet-body form">
                                <!-- BEGIN FORM-->
                                <form action="#" id="Lab_form" class="form-horizontal">
                                <div class="form-body">
                                  <br/>
                                    <div class="alert alert-danger display-hide">
                                        <button  class="close" data-close="alert"></button>
                                        <span id="spnMsg">
                                        يـوجد بـعـض الادخـالات الخـاطئة، الرجـاء التأكد من القيم المدخلة
                                        </span>
                                    </div>
                                    <div class="alert alert-success display-hide">
                                        <button class="close" data-close="alert"></button>
                                          تـم عملية حـفـظ البيـانات بنجـاح !
                                    </div>
                                    <div>
                                    <input id="hdnLAction" name="hdnLAction" type="hidden" value="<?php echo $Laction;?>" />
                                    <input id="hdnLabOrderNo" name="hdnLabOrderNo" type="hidden" value="" />
                                    
                                    </div>
                                               <div class="table-scrollable" style="white-space: nowrap;">
                                                      <table class="table table-striped table-hover table-bordered" id="accordion2">
                                                      <thead>
                                                      <tr class="bg-grey-steel">
                                                          <th scope="col">
                                                               #
                                                          </th>
                                                          <th scope="col">
                                                          	اسم الفحص
                                                               <span class="font-red">
                                                              * </span>
                                                          </th>
                                                          <th scope="col">&nbsp;
                                                               
                                                          </th>
                                                      </tr>
                                                      <tr>
                                                          <th>&nbsp;
                                                               
                                                          </th>
                                                         
                                                          <th>
                                                               <select id="drpTestName" name="drpTestName"
                                                               class="form-control input-sm input-small" >
                                                                      <option value="">اختر...</option>
                                                                      <?php
                                                                       foreach($labTests as $row)
                                                                       {
                                                                          echo '<option value="'.$row->category_id.'">'
                                                                                  .$row->NAME_EN.'</option>';
                                                                       }
                                                                       ?>
                                                                </select>
                                                          </th>
                                                         
                                                          
                                                          <th>
                                                               <button id="btnAddTest" name="btnAddTest" type="button" 
                                                               class="btn btn-circle green-turquoise btn-sm" onclick="addTest()">
                                                              <i id="iConst" class="fa fa-plus"></i></button>
                                                          </th>
                                                      </tr>
                                                      </thead>
                                                      <tbody id="tbdTest">
                                                      <?php
													  $i=0;
													  if(isset($lab_info))
													  {
														  $labCategoryId = "";
														  $i=1;
														  foreach($lab_info as $lab_row)
														  {
															  if ($labCategoryId != $lab_row->category_id)
															  {
																  if ($labCategoryId != '')
																  {
																	  echo '</td>';
																	  echo '<td>&nbsp;</td>';
																	  echo '</tr>';
																  }
																  $labCategoryId = $lab_row->category_id;
																  
																  echo '<tr>
																  		<td>'.$i.'</td>
																  		<td colspan="2">
																	  	  <a class="accordion-toggle" data-toggle="collapse" 
																		     data-parent="#accordion2" href="#collapse_2'.$i.'">'
																			 .$lab_row->Cat_name.
																		  '</a>
																		</td>
															  		  </tr>';
															  
															  		echo '<tr id="collapse_2'.$i.'" class="panel-collapse collapse">
																			<td>&nbsp;</td>
																			<td>';
																	$i++;
															  }
															  echo'<div class="col-md-9">
					  												<div class="col-md-2">'.$lab_row->Item_name.'</div>
					  												<div class="col-md-4">
					  												  <input type="text" id="txt'.$lab_row->lab_order_results_id.'" 
																	    name="txt'.$lab_row->lab_order_results_id.'"
																		class="form-control" value="'.$lab_row->result.'" />
					  												</div>
					  												<div class="col-md-2">
																	 <button id="btnAddTest" name="btnAddTest" type="button"
																	  class="btn btn-circle green-turquoise btn-sm" 
																	  onclick="addResult('.$lab_row->lab_order_results_id.')">
																	  <i id="iConst" class="fa fa-plus"></i></button>
					  												</div>
					  												</div>';
													 		  
														  }
													  }
													  ?>
                                                       <!--<tr>
                                                             <td>  </td>
                                                              
                                                              <td>
              
                                                              <td> alex </td>
                                                              
                                                              <td>
                                                                  <a class="delete" href="javascript:;"> Delete </a>
                                                              </td>
                                                          </tr>-->
                                                      </tbody>
                       
                                                  <?php  /*  
                                                    foreach($LabOrderTest as $row)
                                                    {
                                      
                                                          echo "<tr>";
                                                          echo '<td style="display:none;" id="lab_order_no'.$i.'">'. $row->lab_order_no. "</td>";
                                                          echo '<td style="display:none;" id="test_code'.$i.'">'. $row->test_code. "</td>";
                                                          echo '<td  id="test_desc'.$i.'">'. $row->test_desc.'</td>';
                                                      
                                                          echo '<td><button id="btnDeleteTest" name="btnDeleteTest" type="button" 
                                                          class="btn btn-circle red-sunglo btn-sm" 
                                                          onclick="deleteTestbyId('.$row->test_code.','.$row->lab_order_no.')">
                                                                             <i id="iConst" class="fa fa-close"></i>
                                                                             </td>';
                                                          
                                                          echo "</tr>";
                                                          
                                                          
                                                          

                                                      }
                                                  */?>
                                                      </table>
                                                     <input id="hdnCountLabOrder" name="hdnCountLabOrder" type="hidden"
                                                      value="<?php echo $i;?>" />
                                      </div>          
                                
                                </div>
                                <!-- END FORM BODY -->
                                <!--<div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="submit" class="btn blue-madison">حـفـظ</button>
                                            <button type="button" class="btn default" 
                                            onclick="window.location='<?php //echo base_url()?>patients/';">عودة</button>
                                        </div>
                                    </div>
                                </div>-->
                            </form>
                               <!-- END FORM-->
                          </div> <!-- END portlet-body -->
                          </div> <!-- END panel-body -->
                      </div>
                  </div>
                  
                  
                  <!--Food-->
                  <div class="panel panel-default">
                      <div class="panel-heading">
                          <h4 class="panel-title">
                          <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapse_3">
                          <strong>#3 الخـطـــة الغــذائيـة</strong>  </a>
                          </h4>
                      </div>
                      <div id="collapse_3" class="panel-collapse collapse">
                          <div class="panel-body">
                              <div class="portlet-body form">
                                <!-- BEGIN FORM-->
                                <form action="#" id="Plan_form" class="form-horizontal">
                                <div class="form-body">
                                  <br/>
                                    <div class="alert alert-danger display-hide">
                                        <button  class="close" data-close="alert"></button>
                                        <span id="spnMsg">
                                        يـوجد بـعـض الادخـالات الخـاطئة، الرجـاء التأكد من القيم المدخلة
                                        </span>
                                    </div>
                                    <div class="alert alert-success display-hide">
                                        <button class="close" data-close="alert"></button>
                                          تـم عملية حـفـظ البيـانات بنجـاح !
                                    </div>
                                    <div>
                                    <input id="hdnPAction" name="hdnPAction" type="hidden" value="<?php echo $Paction;?>" />
                                    <input id="hdnNutritionplanid" name="hdnNutritionplanid" type="hidden" 
                                    value="<?php echo $outpatientnutritionId;?>" />
                                    
                                    </div>
                                    
                                    <div class="form-group">
                          <label class="control-label col-md-3">الخطة الغذائية<span class="required">
                          * </span>
                          </label>
                          <div class="col-md-4">
                              <select class="form-control " id="drpPlan" name="drpPlan" onchange="drpplan_change();">
                                  <option value="">اختر...</option>
                                  <?php 
								 
								  foreach ($plantype as $row)
								  {
									   $selected = '';
									  if ($row->sub_constant_id == $plan_id)
									  	$selected = 'selected="selected"';
									  
									  echo ' <option value="'.$row->sub_constant_id.'"'.$selected.'>'
									  						 .$row->sub_constant_name.'</option>';
								  }
								  
								  ?>
                              </select>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="control-label col-md-3">نموذج رقم<span class="required">
                          * </span>
                          </label>
                       <div class="col-md-4">
                              <select class="form-control " id="drpModel" name="drpModel" onchange="drpmodel_change();">
                                  
                                  <?php 
								  foreach ($plan_model as $row)
								  {
									   $selected = '';
									  if ($model_num == $row->model_num)
									  	$selected = 'selected="selected"';
									  
									  echo ' <option value="'.$row->model_num.'"'.$selected.'>'
									  						 .$row->model_num.'</option>';
								  }
								  ?>
                              </select>
                          </div>
                      </div> 
					<div class="form-group">
                          <label class="control-label col-md-3">تـاريخ بدء الخطة <span class="required">
                          * </span>
                          </label>
                          <div class="col-md-4">
                              <div class="input-group date date-picker" data-date-format="yyyy-mm-dd">
                                  <input type="text" class="form-control" readonly id="dpStartdate" name="dpStartdate"
                                  value="<?php if(isset($startdate)) echo $startdate; else echo $currentDate; ?>" >
                                  <span class="input-group-btn">
                                  <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                  </span>
                              </div>
                              <!-- /input-group -->
                          </div>
                          <div class="col-md-4">
                               <label id="lblAge" class="control-label"></label>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="control-label col-md-3">تـاريخ نهاية الخطة <span class="required">
                          * </span>
                          </label>
                          <div class="col-md-4">
                              <div class="input-group date date-picker" data-date-format="yyyy-mm-dd">
                                  <input type="text" class="form-control" readonly id="dpEnddate" name="dpEnddate"
                                  value="<?php if(isset($enddate)) echo $enddate;?>">
                                  <span class="input-group-btn">
                                  <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                  </span>
                              </div>
                              <!-- /input-group -->
                              </div>
                              <div class="col-md-4">
                                   <label id="lblAge" class="control-label"></label>
                              </div>
                          </div>
                          <div class="form-group">
                                <label class="control-label col-md-3">ملاحظات <span class="required">
                                * </span>
                                </label>
                                <div class="col-md-4">
                                    <textarea name="txtNotes" id="txtNotes" cols="70" rows="2" class="form-control"><?php if(isset($notes)) echo $notes;?></textarea>
                                </div>
                            </div>
                         <!--               Nutration plan              --> 
                         <div id="dvNutrationplan"><?php if(isset($plan_table)) echo $plan_table;?></div>
                         </div>
                          <!-- END FORM BODY -->
                          <div class="form-actions">
                              <div class="row">
                                  <div class="col-md-offset-3 col-md-9">
                                      <button type="submit" class="btn blue-madison">حـفـظ</button>
                                      <button type="button" class="btn default" 
                                      onclick="window.location='<?php echo base_url()?>patientcont/patientlist';">عودة</button>
                                  </div>
                              </div>
                          </div>
                            </form>
                               <!-- END FORM-->
                          </div> <!-- END portlet-body -->
                          </div> <!-- END panel-body -->
                          
                      </div>
                      
                  </div>
                  <!---->
                  </div>
                   <div align="center">
                <button type="button" class="btn blue-madison" onclick="endVisit();">إنهاء الجلسة</button>    
                </div>
              </div>
              
          </div>
				</div>
			</div>
			<!-- END PAGE CONTENT-->
<!-- END PAGE CONTENT-->