<!-- END PAGE HEADER-->
<!-- BEGIN PAGE CONTENT-->
<div class="row">
	<div class="col-md-12">
      <!-- Begin: life time stats -->
      <div class="portlet">
          <div class="portlet-title">
              <div class="caption">
                  <i class="fa fa-user"></i>المســتخدمين
              </div>
          </div>
          <div class="portlet-body">
              <div class="table-container">
                  <div class="table-actions-wrapper">
                      <span>
                      </span>
                      
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
                  
                  <table class="table table-striped table-bordered table-hover" id="datatable_ajax">
                  <thead>
                  <tr role="row" class="heading">
                      <th width="2%">
                          #
                      </th>
                      <th width="13%">
                           اسم المستخدم
                      </th>
                      <th width="15%">
                           الرقـم الوظيـفي
                      </th>
                      <th width="20%">
                           اسم المـوظـف
                      </th>
                      <th width="15%">
                           المسـمى الوظيـفي
                      </th>
                      <th width="15%">
                           نوع المستخدم
                      </th>
                      <th width="10%">
                           حالة المستخدم
                      </th>
                      <th width="10%">&nbsp;
                           
                      </th>
                  </tr>
                  <tr role="row" class="filter">
                      <td>
                      </td>
                      <td>
                          <input type="text" class="form-control form-filter input-sm" id="txtUsername" name="txtUsername">
                      </td>
                      <td>
                          <input type="text" class="form-control form-filter input-sm" id="txtEmpid" name="txtEmpid">
                      </td>
                      <td>
                          <input type="text" class="form-control form-filter input-sm" id="txtName" name="txtName">
                      </td>
                      <td>
                          <select id="drpJobtitle" name="drpJobtitle" class="form-control form-filter input-sm">
                              <option value="">اختر...</option>
                              <?php
							  foreach($job_title as $row)
							  {
								  echo '<option value="'.$row->sub_constant_id.'">'.$row->sub_constant_name.'</option>';
							  }
							  ?>
                          </select>                      
                      </td>
                      <td>
                          <select id="drpUsertype" name="drpUsertype" class="form-control form-filter input-sm">
                              <option value="">اختر...</option>
                              <?php
							  foreach($user_type as $row)
							  {
								  echo '<option value="'.$row->sub_constant_id.'">'.$row->sub_constant_name.'</option>';
							  }
							  ?>
                          </select>
                      </td>
                      <td>
                          <select id="drpIsactive" name="drpIsactive" class="form-control form-filter input-sm">
                              <option value="">اختر...</option>
                              <option value="1">فعال</option>
                              <option value="0">غير فعال</option>
                          </select>
                      </td>
                      <td>
                         <button class="btn btn-sm yellow filter-submit margin-bottom"><i class="fa fa-search"></i> </button>
                         <button class="btn btn-sm red filter-cancel"><i class="fa fa-times"></i> </button>
                      </td>
                  </tr>
                  </thead>
                  <tbody>
                  
                  </tbody>
                  </table>
              </div>
          </div>
      </div>
      <!-- End: life time stats -->
  </div>
</div>
<!-- END PAGE CONTENT-->