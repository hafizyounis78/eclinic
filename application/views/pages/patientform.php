<!-- END PAGE HEADER-->
<!-- BEGIN PAGE CONTENT-->
<?php
$ction ="addpatient";
$page_title = "إضافة مريض";
$readonly = '';
if (isset($patient_info))
{
	unset($_SESSION['update']);
	foreach($patient_info as $patient_row);
	$ction ="updatepatient";
	$page_title = "تعـــديل مريض";
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
              <form action="#" id="Patient_form" class="form-horizontal">
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
                      <input id="hdnAction" name="hdnAction" type="hidden" value="<?php echo $ction;?>" />
                      <input id="hdnPatientFileId" name="hdnPatientFileId" type="hidden" value="<?php if(isset($patient_row->patient_file_id)) echo $patient_row->patient_file_id;?>" />
                      </div>
                                           
                      <div class="form-group">
                          <label class="control-label col-md-3">رقم الهوية  <span class="required">
                          * </span>
                          </label>
                          <div class="col-md-4">
                              <input type="text" id="txtPatientId" name="txtPatientId" data-required="1" class="form-control" value="<?php if(isset($patient_row->patient_id)) echo $patient_row->patient_id;?>"/>
                          </div>
                      </div>
                      
                      
                      <div class="form-group">
                        <label class="control-label col-md-3">الاســـم <span class="required">
                        * </span>
                        </label>
                        <div class="col-md-2">
                            <input type="text" id="txtFname" name="txtFname" data-required="1" class="form-control input-small" placeholder="الاسم الاول" value="<?php if(isset($patient_row->first_name)) echo $patient_row->first_name;?>"/>
                        </div>
                        <div class="col-md-2">
                            <input type="text" id="txtMname" name="txtMname" data-required="1" class="form-control input-small" placeholder="اسم الاب" value="<?php if(isset($patient_row->middle_name)) echo $patient_row->middle_name;?>"/>
                        </div>
                        <div class="col-md-2">
                            <input type="text" id="txtThname" name="txtThname" data-required="1" class="form-control input-small" placeholder="اسم الجد" value="<?php if(isset($patient_row->third_name)) echo $patient_row->third_name;?>"/>
                        </div>
                        <div class="col-md-2">
                            <input type="text" id="txtLname" name="txtLname" data-required="1" class="form-control input-small" placeholder="اسم العائلة" value="<?php if(isset($patient_row->last_name)) echo $patient_row->last_name;?>"/>
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
                          <label class="control-label col-md-3">النوع الطبيعي <span class="required">
                          * </span>
                          </label>
                          <div class="col-md-4">
                              <div class="radio-list" data-error-container="#form_2_membership_error">
                                  <label>
                                  <input type="radio" id="rdSexMale" name="rdSex" value="1" 
                                  <?php 
								  	  if(isset($patient_row->sex_id) && $patient_row->sex_id == 1) echo 'checked="checked"';
								  ?>
                                  />
                                  ذكـر </label>
                                  <label>
                                  <input type="radio" id="rdSexFemale" name="rdSex" value="2"
                                  <?php 
								  	  if(isset($patient_row->sex_id) && $patient_row->sex_id == 2) echo 'checked="checked"';
								  ?>
                                  />
                                  انـثى </label>
                              </div>
                              <div id="form_2_membership_error">
                              </div>
                          </div>
                      </div>
                      
                       <div class="form-group">
                          <label class="control-label col-md-3">الحـالة الاجتمـاعية <span class="required">
                          * </span>
                          </label>
                          <div class="col-md-4">
                              <select class="form-control select2me" id="drpstatus" name="drpstatus">
                                  <option value="">اختر...</option>
                                  <?php 
								  foreach ($status as $status_row)
								  {
									  $selected = '';
									  
									  if ($patient_row->status_id == $status_row->sub_constant_id)
									  	$selected = 'selected="selected"';
									  
									  echo ' <option value="'.$status_row->sub_constant_id.'" '.$selected.'>'
									  						 .$status_row->sub_constant_name.'</option>';
								  }
								  ?>
                              </select>
                          </div>
                      </div>
                      
                      <div class="form-group">
                          <label class="control-label col-md-3">العنوان : المحـافظة <span class="required">
                          * </span>
                          </label>
                          <div class="col-md-4">
                              <select class="form-control " id="drpGovernorate" name="drpGovernorate" onchange="governorate_change()">
                               <option value="">اختر...</option>
                                  <?php 
								  foreach ($governorate as $governorate_row)
								  {
									  $selected = '';
									  
									  if ($patient_row->governorate_id == $governorate_row->sub_constant_id)
									  	$selected = 'selected="selected"';
									  
									  echo ' <option value="'.$governorate_row->sub_constant_id.'" '.$selected.'>'
									  						 .$governorate_row->sub_constant_name.'</option>';
								  }
								  ?>
                              </select>
                          </div>
                      </div>
                      <div class="form-group">
                            <label class="control-label col-md-3">المدينة <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-4">
                                <select class="form-control" id="drpRegion" name="drpRegion" onchange="region_change();">
                                    <option value="">اختر...</option>
                        <?php 
                        foreach ($region as $region_row)
                      {
                          $selected = '';
                          
                          if ($patient_row->region_id == $region_row->sub_constant_id)
                            $selected = 'selected="selected"';
                          
                          echo ' <option value="'.$region_row->sub_constant_id.'" '.$selected.'>'
                                                 .$region_row->sub_constant_name.'</option>';
                      }
                      ?>
                        
                                    
                                </select>
                            </div>
                      </div>
                      
                      <div class="form-group">
                            <label class="control-label col-md-3"> الحي <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-4">
                                <select class="form-control" id="drpFulladdress" name="drpFulladdress">
                                    <option value="">اختر...</option>
                        <?php 
                        foreach ($fulladdress as $fulladdress_row)
                      {
                          $selected = '';
                          
                          if ($patient_row->full_address == $fulladdress_row->sub_constant_id)
                            $selected = 'selected="selected"';
                          
                          echo ' <option value="'.$fulladdress_row->sub_constant_id.'" '.$selected.'>'
                                                 .$fulladdress_row->sub_constant_name.'</option>';
                      }
                      ?>				
                                </select>
                            </div>
                      </div>
                       
                      
                                           
                      <div class="form-group">
                          <label class="control-label col-md-3">رقم الهاتف &nbsp;&nbsp;&nbsp;
                          </label>
                          <div class="col-md-4">
                              <input type="text" id="txtPhone" name="txtPhone" class="form-control"
                               value="<?php if(isset($patient_row->phone)) echo $patient_row->phone;?>"
                              />
                          </div>
                      </div>
                      
                      <div class="form-group">
                          <label class="control-label col-md-3">رقم الجوال   &nbsp;&nbsp;&nbsp;
                          </label>
                          <div class="col-md-4">
                              <input type="text" id="txtMobile" name="txtMobile" class="form-control"
                              value="<?php if(isset($patient_row->mobile)) echo $patient_row->mobile;?>"
                              />
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