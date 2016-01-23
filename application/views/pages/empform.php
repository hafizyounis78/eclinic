<!-- END PAGE HEADER-->
<!-- BEGIN PAGE CONTENT-->
<?php
$ction ="addemployee";
$page_title = "اضـــافة موظف";
$readonly = '';
if (isset($employee_info))
{
	unset($_SESSION['update']);
	foreach($employee_info as $employee_row);
	$ction ="updateemployee";
	$page_title = "تعـــديل موظف";
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
              <form action="#" id="employee_form" class="form-horizontal">
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
                      </div>
                      <div class="form-group">
                          <label class="control-label col-md-3">رقم الهوية <span class="required">
                          * </span>
                          </label>
                          <div class="col-md-4">
                              <input type="text" id="txtNationalId" name="txtNationalId" data-required="1" class="form-control" value="<?php if(isset($employee_row->national_id)) echo $employee_row->national_id;?>"  onblur="check_emp_id()"/>
                          </div>
                      </div>
                      
                      <div class="form-group">
                          <label class="control-label col-md-3">الرقم الوظيفي <span class="required">
                          * </span>
                          </label>
                          <div class="col-md-4">
                              <input type="text" id="txtEmployeeId" name="txtEmployeeId" data-required="1" class="form-control" value="<?php if(isset($employee_row->emp_id)) echo $employee_row->emp_id;?>"/>
                          </div>
                      </div>
                      
                      <div class="form-group">
                          <label class="control-label col-md-3">اسـم المـوظف <span class="required">
                          * </span>
                          </label>
                          <div class="col-md-4">
                              <input type="text" id="txtName" name="txtName" data-required="1" class="form-control" value="<?php if(isset($employee_row->name)) echo $employee_row->name;?>" />
                          </div>
                      </div>
                      
                      <div class="form-group">
                          <label class="control-label col-md-3">الجنـس&nbsp;&nbsp;&nbsp;
                          </label>
                          <div class="col-md-4">
                              <div class="radio-list" data-error-container="#form_2_membership_error">
                                  <label>
                                  <input type="radio" id="rdSexMale" name="rdSex" value="1" checked="checked" <?php if (isset($employee_row->sex_id)) {if ($employee_row->sex_id==1) echo 'checked=checked';}?> />
                                  ذكـر </label>
                                  <label>
                                  <input type="radio" id="rdSexFemale" name="rdSex" value="2" <?php if (isset($employee_row->sex_id)) {if ($employee_row->sex_id==2) echo 'checked=checked';}?>/>
                                  انـثى </label>
                                  
                              </div>
                              
                          </div>
                      </div>
                      
                       <div class="form-group">
                          <label class="control-label col-md-3">المسـمى الوظيـفي<span class="required">
                          * </span>
                          </label>
                          <div class="col-md-4">
                              <select class="form-control select2me" id="drpJobtitle" name="drpJobtitle">
                                  <option value="">اختر...</option>
                                  <?php
								  foreach($job_title as $row_job_title)
								  {
									  $selected = '';
									  if(isset($employee_row->job_title_id) && $employee_row->job_title_id == $row_job_title->sub_constant_id)
									  	$selected = 'selected="selected"';
									  
									  echo '<option value="'.$row_job_title->sub_constant_id.'" '.$selected.'>'
									  						.$row_job_title->sub_constant_name.
										   '</option>';
								  }
								  ?>
                              </select>
                          </div>
                      </div>
                      
                      <div class="form-group">
                          <label class="control-label col-md-3">رقم الجوال <span class="required">
                          * </span>
                          </label>
                          <div class="col-md-4">
                              <input type="text" id="txtMobile" name="txtMobile" data-required="1" class="form-control" value="<?php if(isset($employee_row->mobile)) echo $employee_row->mobile;?>"/>
                          </div>
                      </div>
                      
                      <div class="form-group">
                          <label class="control-label col-md-3">رقم الهاتف&nbsp;&nbsp;&nbsp;
                          </label>
                          <div class="col-md-4">
                              <input type="text" id="txtPhone" name="txtPhone" class="form-control" value="<?php if(isset($employee_row->phone)) echo $employee_row->phone;?>"/>
                          </div>
                      </div>
                      
                      <div class="form-group">
                          <label class="col-md-3 control-label">البريد الالكتروني <span class="required">
                          * </span>
                          </label>
                          <div class="col-md-4">
                              <div class="input-group">
                                  <span class="input-group-addon">
                                  <i class="fa fa-envelope"></i>
                                  </span>
                                  <input type="email" id="txtEmail" name="txtEmail" class="form-control" placeholder="البريد الالكتروني" value="<?php if(isset($employee_row->email)) echo $employee_row->email;?>">
                              </div>
                          </div>
                      </div>
                      
                      <div class="form-group">
                          <label class="control-label col-md-3">مـوظـف حـالي&nbsp;&nbsp;&nbsp;
                          </label>
                          <div class="col-md-4">
                              <div class="checkbox-list" data-error-container="#form_2_services_error">
                                  <label>
                                  <input type="checkbox" value="1" id="chbxIsactive"  name="chbxIsactive" 
                                   <?php 
								  $checked = ' checked="checked"';
								  if(isset($employee_row->active_account)  && $employee_row->active_account == 0) 								  $checked = '';
								  echo $checked;?> 

                                  /> </label>
                              </div>
                             
                          </div>
                      </div>
                  </div>
                  <!-- END FORM BODY -->
                  <div class="form-actions">
                      <div class="row">
                          <div class="col-md-offset-3 col-md-9">
                              <button type="submit" class="btn blue-madison">حـفـظ</button>
                              <button type="button" class="btn default" onclick="window.location='<?php echo base_url()?>employees/';">عودة</button>
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