<!-- END PAGE HEADER-->
<!-- BEGIN PAGE CONTENT-->
<div class="row">
	<div class="col-md-12">
      <!-- Begin: life time stats -->
      <div class="portlet">
          <div class="portlet-title">
              <div class="caption">
                  <i class="fa fa-briefcase"></i>الإستعلام العام على المرضى
              </div>
          </div>
          <div class="portlet-body">
              <div class="table-container">
                 
                  <table class="table table-striped table-bordered table-hover" id="Patientdatatable_ajax">
                  <thead>
                  <tr role="row" class="heading">
                      <th width="2%">
                          <input type="checkbox" class="group-checkable">
                      </th>
                       <th width="12%">
                           رقـم الملف
                      </th>
                      <th width="12%">
                           رقـم الهوية
                      </th>
                      <th width="20%">
                           اســم المريض
                      </th>
                      <th width="10%">
                           رقم الهاتف
                      </th>
                      <th width="12%">
                           رقم الجوال
                      </th>
                      
                      <th width="10%">
                           المحافظة
                      </th>
                       <th width="20%">
                           تاريخ أخر زيارة
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
                          <input type="text" class="form-control form-filter input-sm" id="txtPatientid" name="txtPatientid">
                      </td>
                      <td>
                          <input type="text" class="form-control form-filter input-sm" id="txtName" name="txtName">
                      </td>
                      <td>
                          <input type="text" class="form-control form-filter input-sm" id="txtPhone" name="txtPhone">
                      </td>
                      <td>
                          <input type="text" class="form-control form-filter input-sm" id="txtMobile" name="txtMobile">
                      </td>
                     
                      <td>
                         <select class="form-control form-filter input-sm" id="drpGovernorate" name="drpGovernorate">
                            <option value="">اختر...</option>
                            <?php
							  foreach($elder_governorate as $row)
							  {
                      			echo '<option value="'.$row->sub_constant_id.'">'.$row->sub_constant_name.'</option>';
							  }
							  ?>
                        </select>
                      </td>
                      <td>
                          <div class="input-group date date-picker margin-bottom-5" data-date-format="yyyy/mm/dd">
                            <input type="text" class="form-control form-filter input-sm dp" readonly name="dpAppfrom" placeholder="من">
                            <span class="input-group-btn">
                            <button class="btn btn-sm default" type="button"><i class="fa fa-calendar"></i></button>
                            </span>
                        </div>
                        <div class="input-group date date-picker" data-date-format="yyyy/mm/dd">
                            <input type="text" class="form-control form-filter input-sm dp" readonly name="dpAppto" placeholder="إلى">
                            <span class="input-group-btn">
                            <button class="btn btn-sm default" type="button"><i class="fa fa-calendar"></i></button>
                            </span>
                        </div>
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