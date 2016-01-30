<!-- END PAGE HEADER-->
<!-- BEGIN PAGE CONTENT-->
<?php
$ction ="addvisit";
$page_title = "إضافة زيارة";
$readonly = '';
if (isset($patient_info))
{
	unset($_SESSION['update']);
	//foreach($patient_info as $patient_row);
	foreach($visit_info as $visit_row);
	//foreach($bodysegment_info as $bodysegment_row);
	//foreach($nutrition_plan_info as $nutrition_plan_row);
	$ction ="updatevisit";
	$page_title = "تعـــديل زيارة";
	$readonly = 'readonly="readonly"';
}
?>

<div class="row">
    <div class="col-md-12">
      <!-- BEGIN VALIDATION STATES-->
      <div class="portlet box blue-madison">
          <div class="portlet-title">
              <div class="caption">
                  <i class="fa fa-briefcase"></i><?php echo $page_title;?>
              </div>
             
          </div>
          <div class="portlet-body form">
              <!-- BEGIN FORM-->
              <form action="#" id="Visit_form" class="form-horizontal">
                  <div class="form-body">
                  	<br/>
                      <div class="alert alert-danger display-hide">
                          <button class="close" data-close="alert"></button>
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
                      
                      </div>
                                           
                      <div class="form-group">
                          <label class="control-label col-md-3">رقم السجل الطبي  <span class="required">
                          * </span>
                          </label>
                          <div class="col-md-1">
                              <input type="text" id="txtPatientFileId" name="txtPatientFileId" data-required="1" class="form-control input-xsmall" value="<?php if(isset($patient_row->patient_file_id)) echo $patient_row->patient_file_id;?>"/>
                          </div>
                          <div class="col-md-3">
                           <input type="text" id="txtName" name="txtName" data-required="1" class="form-control" placeholder="الاسم" value="<?php if(isset($patient_row->first_name)) echo $patient_row->first_name;?>"/>
                        </div>
                      </div>
                                           
                      <div class="form-group">
                          <label class="control-label col-md-3">تـاريخ الميـلاد <span class="required">
                          * </span>
                          </label>
                          <div class="col-md-4">
                              <div class="input-group date date-picker" data-date-format="yyyy-mm-dd">
                                  <input type="text" class="form-control" readonly id="dpDob" name="dpDob"
                                  value="<?php if(isset($patient_row->dob)) echo $patient_row->dob;?>"
                                 onchange="claculateAge();" >
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
                            <label class="control-label col-md-3">تـاريخ  الزيارة <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-2">
                              <div class="input-group date date-picker" data-date-format="yyyy-mm-dd">
                                  <input type="text" class="form-control" readonly id="dpVisitdate" name="dpVisitdate" value="<?php if(isset($visit_row->visit_date)) echo $visit_row->visit_date;?>">
                                  <span class="input-group-btn">
                                  <button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
                                  </span>
                              </div>
                              <!-- /input-group -->
                          </div>
                          <div class="col-md-2">
                                <div class="input-group">
                                    <input type="text" id="txtVisittime" name="txtVisittime"  value="<?php if(isset($visit_row->visit_time)) echo $visit_row->visit_time;?>" 
                                    class="form-control timepicker timepicker-24" >
                                    <span class="input-group-btn">
                                    <button class="btn default" type="button"><i class="fa fa-clock-o"></i></button>
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
									  
									  echo ' <option value="'.$status_row->sub_constant_id.'" '.$selected.'>'
									  						 .$status_row->sub_constant_name.'</option>';
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
                               value="<?php if(isset($patient_row->weight)) echo $patient_row->weight;?>"
                              />
                          </div>
                      </div>
                      
                      <div class="form-group">
                          <label class="control-label col-md-3">الطول   &nbsp;&nbsp;&nbsp;
                          </label>
                          <div class="col-md-4">
                              <input type="text" id="txtLength" name="txtLength" class="form-control"
                              value="<?php if(isset($patient_row->length)) echo $patient_row->length;?>"
                              />
                          </div>
                      </div>
                      
                      
                      <div class="form-group">
                          <label class="control-label col-md-3"> BMI   &nbsp;&nbsp;&nbsp;
                          </label>
                          <div class="col-md-4">
                              <input type="text" id="txtBmi" name="txtBmi"  readonly class="form-control"
                              value="<?php if(isset($patient_row->bmi)) echo $patient_row->bmi;?>"
                              />
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="control-label col-md-3">الخطة الغذائية<span class="required">
                          * </span>
                          </label>
                          <div class="col-md-4">
                              <select class="form-control " id="drpPlan" name="drpPlan">
                                  <option value="">اختر...</option>
                                  <?php 
								  foreach ($plantype as $row)
								  {
									  
									  
									  echo ' <option value="'.$status_row->sub_constant_id.'" >'
									  						 .$status_row->sub_constant_name.'</option>';
								  }
								  ?>
                              </select>
                          </div>
                      </div>
                       

                  </div>
                  <!-- END FORM BODY -->
                  <div class="form-actions">
                      <div class="row">
                          <div class="col-md-offset-3 col-md-9">
                              <button type="submit" class="btn blue-madison">حـفـظ</button>
                              <button type="button" class="btn default" onclick="window.location='<?php echo base_url()?>patients/';">عودة</button>
                          </div>
                      </div>
                  </div>
              </form>
              <!-- END FORM-->
          </div>
          <!-- END VALIDATION STATES-->
      </div>
  </div>
</div>
<!-- END PAGE CONTENT-->