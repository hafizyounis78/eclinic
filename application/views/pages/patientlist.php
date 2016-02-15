<!-- END PAGE HEADER-->
<!-- BEGIN PAGE CONTENT-->
<div class="row">
	<div class="col-md-12">
      <!-- Begin: life time stats -->
      <div class="portlet">
          <div class="portlet-title">
              <div class="caption">
                  <i class="fa fa-briefcase"></i>المرضى
              </div>
          </div>
          <div class="portlet-body">
              <div class="table-container">
                 
                  <table class="table table-striped table-bordered table-hover" id="PatientListdatatable_ajax">
                  <thead>
                  <tr role="row" class="heading">
                      <th width="2%">
                          <input type="checkbox" class="group-checkable">
                      </th>
                       <th width="12%">
                           رقـم الملف
                      </th>
                      <th width="20%">
                           اســم المريض
                      </th>
                      <th width="20%">
                          تاريخ الزيارة
                      </th>
                      <th width="12%">
                           نوع الزيارة
                      </th>
                      
                      <th width="10%">
                           حالة الزيارة
                      </th>
                       
                      <th width="10%">&nbsp;
                           
                      </th>
                  </tr>
                  <tr role="row" class="filter">
                      <td>
                      </td>
                    	 <td>
                          <input type="text" class="form-control form-filter input-sm" id="txtPatientFileid" name="txtPatientFileid">
                      </td>
                      
                      <td>
                          <input type="text" class="form-control form-filter input-sm" id="txtName" name="txtName">
                      </td>
                       <td>
                          <div class="input-group date date-picker margin-bottom-5" data-date-format="yyyy/mm/dd">
                            <input type="text" class="form-control form-filter input-sm dp" readonly name="dpVistfrom" placeholder="من">
                            <span class="input-group-btn">
                            <button class="btn btn-sm default" type="button"><i class="fa fa-calendar"></i></button>
                            </span>
                        </div>
                        <div class="input-group date date-picker" data-date-format="yyyy/mm/dd">
                            <input type="text" class="form-control form-filter input-sm dp" readonly name="dpVisitto" placeholder="إلى">
                            <span class="input-group-btn">
                            <button class="btn btn-sm default" type="button"><i class="fa fa-calendar"></i></button>
                            </span>
                        </div>
                      </td>
                      <td>
                         <select class="form-control form-filter input-sm" id="drpVisitType" name="drpVisitType">
                            <option value="">اختر...</option>
                            <?php
							  foreach($visitType as $row)
							  {
                      			echo '<option value="'.$row->sub_constant_id.'">'.$row->sub_constant_name.'</option>';
							  }
							  ?>
                        </select>
                      </td>
<td>
                         <select class="form-control form-filter input-sm" id="drpVisitStatus" name="drpVisitStatus">
                            <option value="">اختر...</option>
                            <?php
							  foreach($visitStatus as $row)
							  {
                      			echo '<option value="'.$row->sub_constant_id.'">'.$row->sub_constant_name.'</option>';
							  }
							  ?>
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