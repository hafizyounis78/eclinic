<!-- END PAGE HEADER-->
<!-- BEGIN PAGE CONTENT-->
<div class="row">
  <div class="col-md-12">
      <!-- BEGIN VALIDATION STATES-->
      <div class="portlet box blue-madison">
          <div class="portlet-title">
              <div class="caption">
                  <i class="fa fa-user"></i>صلاحيات انواع المستخدمين
              </div>
              
          </div>
          <div class="portlet-body form">
              <!-- BEGIN FORM-->
              <form action="#" id="form_sample_3" class="form-horizontal">
                  <div class="form-body">
                  	<br/>
                      <div class="alert alert-danger display-hide">
                          <button class="close" data-close="alert"></button>
                          يـوجد بـعـض الادخـالات الخـاطئة، الرجـاء التأكد من القيم المدخلة
                      </div>
                      <div class="alert alert-success display-hide">
                          <button class="close" data-close="alert"></button>
                          Your form validation is successful!
                      </div>
                      
                       <div class="form-group">
                          <label class="control-label col-md-3">نوع المستخدم <span class="required">
                          * </span>
                          </label>
                          <div class="col-md-4">
                              <select class="form-control select2me" id="drpUsertypeperm" name="drpUsertypeperm">
                                  <option value="">اختر...</option>
                                  <?php 
                                  foreach($user_type as $row_user_type)
								  {
									   echo '<option value="'.$row_user_type->sub_constant_id.'" '.$selected.'>'
									  						.$row_user_type->sub_constant_name.
										   '</option>';
								  }
								  ?>

                              </select>
                          </div>
                      </div>
                      
                      <div id="dvMenue" class="row" style="display:none">
                       	  <label class="control-label col-md-3">صلاحيات المستخدم</label>
                          <div class="col-md-4">
                              <select multiple="multiple" class="multi-select" id="my_multi_select2" name="my_multi_select2[]">
                              
                              </select>
                          </div>
                      </div>
                  </div>
                  <!-- END FORM BODY -->
                  <div class="form-actions">
                      <div class="row">
                          
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