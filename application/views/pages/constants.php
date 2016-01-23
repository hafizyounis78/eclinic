<!-- END PAGE HEADER-->
<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
      <!-- BEGIN VALIDATION STATES-->
      <div class="portlet box blue-madison">
          <div class="portlet-title">
              <div class="caption">
                  <i class="fa fa-cog"></i> ثـوابت النظـام
              </div>
              <div class="tools">
                  <a href="#" class="reload" onclick="reload_constant_form();return false;">
                  </a>
              </div>
          </div>
          <div class="portlet-body form">
              <!-- BEGIN FORM-->
              <form action="#" id="constant_form" class="form-horizontal">
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
                      <div class="row">
                        <div class="col-md-6">
                          <div id="dvConstErrorMsg" class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button>
                            خـطـأ ... الرجـاء ادخــال الثـابت
                          </div>
                          <div id="dvConstSuccessMsg" class="alert alert-success display-hide">
                            <button class="close" data-close="alert"></button>
                            تـمـت عـمليـة الحـفـظ بنـجـاح
                      	  </div>
                          <table class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th>
                                <div class="col-md-4">
                                   اسم الثابت 
                                </div>
                                <div class="col-md-6">
                                  <input id="txtConstantName" name="txtConstantName" type="text" 
                                  class="form-control form-filter input-sm" >
                                  <input id="hdnConstantid" name="hdnConstantid" type="hidden" value="" />
                                </div>
                                <div class="col-md-2">
                                  <button id="btnAddconstant" name="btnAddconstant" type="button" class="btn btn-circle green-turquoise btn-sm">
                                  <i id="iConst" class="fa fa-plus"></i></button> 
                                </div>
                              </th>
                            </tr>
                           </thead>
                           <tbody id="tbdConst">
                           <?php
						   foreach($constants as $row)
						   {
							   echo '<tr>
									  <td>
									    <div class="col-md-11">
										 <span class="font-blue">'.$row->constant_name.'</span></div>
										<div class="col-md-1">
										  <a onclick="show_sub('.$row->constant_id.',\''.$row->constant_name.'\')">
										  <i class="fa fa-arrow-left font-blue"></i></a>
									  	</div>
									  </td>
								   </tr>';
						   }
						   ?>
                            
                           </tbody>
                           </table>    
                        </div>
                         <!-- Sub Constant Table -->
                        <div id="dvSub" class="col-md-6" style="display:none">
                          <div id="dvSubErrorMsg" class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button>
                            خـطـأ ... الرجـاء ادخــال الثـابت الفـرعـي
                          </div>
                          <div id="dvSubSuccessMsg" class="alert alert-success display-hide">
                            <button class="close" data-close="alert"></button>
                            تـمـت عـمليـة الحـفـظ بنـجـاح
                          </div>
                          <table class="table table-bordered table-striped">
                           <thead>
                            <tr>
                              <th>
                                <div class="col-md-4"> الثابت الفرعي </div>
                                <div class="col-md-6">
                                  <input id="txtSubConstantName" name="txtSubConstantName" type="text" 
                                  class="form-control form-filter input-sm" >
                                </div>
                                <div class="col-md-2">
                                  <button id="btnAddsub" name="btnAddsub" type="button" class="btn btn-circle green-turquoise btn-sm">
                                  <i id="iSub" class="fa fa-plus"></i></button>
                                  <input id="hdnSubConstid" name="hdnSubConstid" type="hidden" value="" />
                                </div>
                              </th>
                            </tr>
                          </thead>
                          <tbody id="tbdSub"></tbody>
                          </table>
                        </div>
                  </div>
                      
                  </div>
                  <!-- END FORM BODY -->
              </form>
              <!-- END FORM-->
          </div>
          <!-- END VALIDATION STATES-->
      </div>
  </div>
</div>
<!-- END PAGE CONTENT-->
