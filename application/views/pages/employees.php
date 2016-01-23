<!-- END PAGE HEADER-->
<!-- BEGIN PAGE CONTENT-->
<div class="row">
	<div class="col-md-12">
      <!-- Begin: life time stats -->
      <div class="portlet">
          <div class="portlet-title">
              <div class="caption">
                  <i class="fa fa-briefcase"></i>المــــوظفـيـن
              </div>
          </div>
          <div class="portlet-body">
              <div class="table-container">
                 
                  <table class="table table-striped table-bordered table-hover" id="Empdatatable_ajax">
                  <thead>
                  <tr role="row" class="heading">
                      <th width="2%">
                          <input type="checkbox" class="group-checkable">
                      </th>
                      <th width="10%">
                           رقـم الهوية
                      </th>
                      <th width="10%">
                           الرقـم الوظيـفي
                      </th>
                      <th width="15%">
                           اسم المـوظـف
                      </th>
                      <th width="10%">
                           المسـمى الوظيـفي
                      </th>
                      <th width="10%">
                           رقـم الجوال
                      </th>
                      <th width="12%">
                           البريد الاكتروني
                      </th>
                      <th width="8%">
                           حالة الموظف
                      </th>
                      <th width="10%">&nbsp;
                           
                      </th>
                  </tr>
                  <tr role="row" class="filter">
                      <td>
                      </td>
                      <td>
                          <input type="text" class="form-control form-filter input-sm" id="txtNationalid" name="txtNational_id">
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
							  foreach($emp_job_title as $row)
							  {
                      			echo '<option value="'.$row->sub_constant_id.'">'.$row->sub_constant_name.'</option>';
							  }
							  ?>
                          </select>                      
                      </td>
                      <td>
                         <input type="text" class="form-control form-filter input-sm" id="txtmobile" name="txtmobile">
                      </td>
                      <td>
                         <input type="text" class="form-control form-filter input-sm" id="txtemail" name="txtemail">
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