<?php
$ction ="adduser";
$page_title = "اضـــافة مستخدم";
$readonly = '';
if (isset($user_info))
{
	unset($_SESSION['update']);
	foreach($user_info as $user_row);
	$ction ="updateuser";
	$page_title = "تعـــديل مستخدم";
	$readonly = 'readonly="readonly"';
}
?>
<!-- END PAGE HEADER-->
<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
      <!-- BEGIN VALIDATION STATES-->
      <div class="portlet box blue-madison">
          <div class="portlet-title">
              <div class="caption">
                  <i class="fa fa-user"></i> <?php echo $page_title;?>
              </div>
              
          </div>
          
          <div id="confirm-reset" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                          <h4 class="modal-title">تأكيد تعديل كلمة المرور</h4>
                      </div>
                      <div class="modal-body">
                          <p>
                               سيتم تعديل كلمة المرور ... هل تود المتابعة؟
                          </p>
                      </div>
                      <div class="modal-footer">
                          <button class="btn default" data-dismiss="modal" aria-hidden="true">تراجع</button>
                          <button data-dismiss="modal" class="btn btn-danger btn-ok" >متابعة</button>
                      </div>
                  </div>
              </div>
          </div>
          
          <div class="portlet-body form">
              <!-- BEGIN FORM-->
              <form action="#" id="user_form" class="form-horizontal">
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
                          <label class="control-label col-md-3">اسـم المـوظف <span class="required">
                          * </span>
                          </label>
                          <div class="col-md-4">
                          	<div class="input-group">
                          	  <span class="input-group-addon">
                              <i class="fa fa-search"></i>
                              </span>
                              <input id="hdnEmployeeId" name="hdnEmployeeId" type="hidden" value="<?php if(isset($user_row->employee_id))echo $user_row->employee_id;?>" />
                              <input type="text" id="txtName" name="txtName" data-required="1" class="form-control"
                              value="<?php if(isset($user_row->name)) echo $user_row->name;?>" 
                              data-error-container="#form_2_error"
                              <?php echo $readonly; ?> />
                            </div>
                            <div id="form_2_error">
                              </div>
                          </div>
                      </div>
                      
                      <div class="form-group">
                          <label class="control-label col-md-3">الرقم الوظيفي <span class="required">
                          * </span>
                          </label>
                          <div class="col-md-4">
                              <input type="text" id="txtEmpId" name="txtEmpId" data-required="1" class="form-control"
                              value="<?php if(isset($user_row->emp_id)) echo $user_row->emp_id;?>" readonly="readonly"/>
                          </div>
                      </div>
                      
                      <div class="form-group">
                          <label class="control-label col-md-3">اسم المستخدم <span class="required">
                          * </span>
                          </label>
                          <div class="col-md-4">
                          	<div class="input-icon right">
                              <i id="iCheck" class=""></i>
                              <input type="text" id="txtUsername" name="txtUsername" data-required="1" class="form-control"
                              value="<?php if(isset($user_row->user_name)) echo $user_row->user_name;?>" 
                              <?php echo $readonly; ?>/>
                            </div>
                          </div>
                      </div>
                      
<?php if ($ction == "adduser") { ?>         
                      <div class="form-group">
                          <label class="control-label col-md-3">كلمة المرور <span class="required">
                          * </span>
                          </label>
                          <div class="col-md-4">
                              <input type="password" id="txtPassword" name="txtPassword" data-required="1" class="form-control"
                              value="<?php if(isset($user_row->passward)) echo $user_row->passward;?>" />
                          </div>
                      </div>
                      
                      <div class="form-group">
                          <label class="control-label col-md-3">تأكيد كلمة المرور <span class="required">
                          * </span>
                          </label>
                          <div class="col-md-4">
                              <input type="password" id="txtPasswordconf" name="txtPasswordconf" data-required="1" 
                              class="form-control" value="<?php if(isset($user_row->passward)) echo $user_row->passward;?>" />
                          </div>
                      </div>
<?php } else if ($ction == "updateuser") {?>
                      
                      <div class="form-group">
                          <label class="control-label col-md-3">اعـادة تعيين كلمة المرور </label>
                          <div class="col-md-4">
                              <a class="btn btn-circle red" href="#" data-toggle="modal" data-target="#confirm-reset" role="button"
                              data-onclick="resetPassword('<?php echo $user_row->user_name;?>')">
                                اعادة تعين كلمة المرور
                                <i class="fa fa-refresh"></i>
                              </a>
                          </div>
                      </div>
<?php } ?>
                      
                       <div class="form-group">
                          <label class="control-label col-md-3">نوع المستخدم <span class="required">
                          * </span>
                          </label>
                          <div class="col-md-4">
                              <select class="form-control select2me" id="drpUsertype" name="drpUsertype">
                                  <option value="">اختر...</option>
                                  <?php
								  foreach($user_type as $row_user_type)
								  {
									  $selected = '';
									  if(isset($user_row->user_type_id) && $user_row->user_type_id == $row_user_type->sub_constant_id)
									  	$selected = 'selected="selected"';
									  
									  echo '<option value="'.$row_user_type->sub_constant_id.'" '.$selected.'>'
									  						.$row_user_type->sub_constant_name.
										   '</option>';
								  }
								  ?>
                              </select>
                          </div>
                      </div>
                      
                      <div class="form-group">
                          <label class="control-label col-md-3">حساب فعال&nbsp;&nbsp;&nbsp;
                          </label>
                          <div class="col-md-4">
                              <div class="checkbox-list" data-error-container="#form_2_services_error">
                                  <label>
                                  <input type="checkbox" value="1" id="chbxIsactive" name="chbxIsactive"
                                  <?php 
								  $checked = ' checked="checked"';
								  if(isset($user_row->active_account) && $user_row->active_account == 0) 
								  $checked = '';
								  echo $checked;?> 
                                  /></label>
                              </div>
                              <div id="form_2_services_error">
                              </div>
                          </div>
                      </div>
                  </div>
                  <!-- END FORM BODY -->
                  <div class="form-actions">
                      <div class="row">
                          <div class="col-md-offset-3 col-md-9">
                              <button type="submit" class="btn blue-madison">حـفـظ</button>
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