<!-- END PAGE HEADER-->
<!-- BEGIN PAGE CONTENT-->
<?php
$ction ="addvisit";
$Laction="";
$page_title = "إضافة زيارة";
$readonly = '';
$disabled = '';
date_default_timezone_set('Asia/Gaza');
$currentDate= date("Y-m-d"); 
$lblClass = ' font-green ';
$lblage = '';
if (isset($patient_info))				
{
	foreach($patient_info as $patient_row);
	$page_title = "إضافة زيارة";
	$ction ="addvisit";

}
else if(isset($visit_info))
{
	foreach($visit_info as $visit_row);
	$page_title = "تعـــديل زيارة";
	$ction ="updatevisit";
	$readonly = 'readonly="readonly"';
	$disabled = 'disabled="disabled" ';
	
	date_default_timezone_set('Asia/Gaza');   
		//date in yyyy-mm-dd format;
  		$birthDate = $visit_row->dob;
		//explode the date to get month, day and year
		$birthDate = explode("-", $birthDate);
		//get age from date or birthdate
		$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[2], $birthDate[1], $birthDate[0]))) > date("md")
		  ? ((date("Y") - $birthDate[0]) - 1)
		  : (date("Y") - $birthDate[0]));
		
		if ($age > 60 )
			$lblClass = ' font-green ';
		else
			$lblClass = ' font-red ';
			
		$lblage = '<b> المريض العضو : <span id="spnAge">'.$age.'</span></b>';
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
                          <button  class="close" data-close="alert"></button>
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
                      <input id="hdnvisitNo" name="hdnvisitNo" type="hidden" value="<?php if(isset($visit_row->outpatient_visit_id)) echo $visit_row->outpatient_visit_id;?>" />
                      </div>
                                           
                      <div class="form-group">
                          <label class="control-label col-md-3">رقم السجل الطبي  <span class="required">
                          * </span>
                          </label>
                          <div class="col-md-1">
                              <input type="text" id="txtPatientFileId" name="txtPatientFileId" data-required="1" class="form-control input-xsmall"  readonly="readonly" value="<?php if(isset($patient_row->patient_file_id)) echo $patient_row->patient_file_id; else if(isset($visit_row->patient_file_id)) echo $visit_row->patient_file_id;?>"/>
                          </div>
                          <div class="col-md-3">
                           <input type="text" id="txtpatientName" name="txtpatientName" data-required="1" class="form-control" placeholder="الاسم" readonly="readonly" value="<?php if(isset($patient_row->name)) echo $patient_row->name;else if(isset($visit_row->name)) echo $visit_row->name;?>"/>
                        </div>
                      </div>
                                           
                      <div class="form-group">
                          <label class="control-label col-md-3">تـاريخ الميـلاد <span class="required">
                          * </span>
                          </label>
                          <div class="col-md-4">
                              <div class="input-group date date-picker" data-date-format="yyyy-mm-dd">
                                  <input type="text" class="form-control" readonly id="dpDob" name="dpDob"
                                  value="<?php if(isset($patient_row->dob)) echo $patient_row->dob;else if(isset($visit_row->dob)) echo $visit_row->dob;?>"
                                 onchange="claculateAge();" >
                                  <span class="input-group-btn">
                                  <button class="btn default" <?php echo $disabled ;?> type="button"><i class="fa fa-calendar"></i></button>
                                  </span>
                              </div>
                              <!-- /input-group -->
                          </div>
                          <div class="col-md-4">
                               <label id="lblAge" class="control-label" <?php echo $lblClass?>>
                                <?php echo $lblage;?></label>
                          </div>
                      </div>
                                                      
                      <div class="form-group">
                            <label class="control-label col-md-3">تـاريخ  الزيارة <span class="required">
                            * </span>
                            </label>
                            <div class="col-md-2">
                              <div class="input-group date date-picker" data-date-format="yyyy-mm-dd">
                                  <input type="text" class="form-control" readonly id="dpVisitdate" name="dpVisitdate" value="<?php echo $currentDate; ?>">
                                  <span class="input-group-btn">
                                  <button class="btn default" <?php echo $disabled ;?> type="button"><i class="fa fa-calendar"></i></button>
                                  </span>
                              </div>
                              <!-- /input-group -->
                          </div>
                          <div class="col-md-2">
                                <div class="input-group">
                                    <input type="text" id="txtVisittime" name="txtVisittime"  value="" <?php echo $readonly ;?>
                                    class="form-control timepicker timepicker-24" >
                                    <span class="input-group-btn">
                                    <button class="btn default"   type="button" <?php echo $disabled ;?>><i class="fa fa-clock-o"></i></button>
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
									  echo ' <option value="'.$row->sub_constant_id.'"'.$selected.' >'
									  						 .$row->sub_constant_name.'</option>';
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
                               value="<?php if(isset($visit_row->weight)) echo $visit_row->weight;?>" onblur="calculat_bmi();"
                              />
                          </div>
                      </div>
                      
                      <div class="form-group">
                          <label class="control-label col-md-3">الطول   &nbsp;&nbsp;&nbsp;
                          </label>;2
                          <div class="col-md-4">
                              <input type="text" id="txtLength" name="txtLength" class="form-control"
                              value="<?php if(isset($visit_row->length)) echo $visit_row->length;?>" onblur="calculat_bmi();"
                              />
                          </div>
                      </div>
                      
                      
                      <div class="form-group">
                          <label class="control-label col-md-3"> BMI   &nbsp;&nbsp;&nbsp;
                          </label>
                          <div class="col-md-4">
                              <input type="text" id="txtBmi" name="txtBmi"  readonly class="form-control"
                              value="<?php if(isset($visit_row->bmi)) echo $visit_row->bmi;?>"
                              />
                          </div>
                      </div>
                    </div>
                  <!-- END FORM BODY -->
                  <div class="form-actions">
                      <div class="row">
                          <div class="col-md-offset-3 col-md-9">
                              <button type="submit" class="btn blue-madison">حـفـظ</button>
                              <button type="button" class="btn default" 
                              onclick="window.location='<?php echo base_url()?>patients/';">عودة</button>
                          </div>
                      </div>
                  </div>
              </form>
              <!-- END FORM-->
              <form action="#" id="Lab_form" class="form-horizontal">
                  <div class="form-body">
                  	<br/>
                      <div class="alert alert-danger display-hide">
                          <button  class="close" data-close="alert"></button>
                          <span id="spnMsg">
                          يـوجد بـعـض الادخـالات الخـاطئة، الرجـاء التأكد من القيم المدخلة
                          </span>
                      </div>
                      <div class="alert alert-success display-hide">
                          <button class="close" data-close="alert"></button>
							تـم عملية حـفـظ البيـانات بنجـاح !
                      </div>
                      <div>
                      <input id="hdnLAction" name="hdnLAction" type="hidden" value="<?php echo $Laction;?>" />
                      <input id="hdnLabOrderNo" name="hdnLabOrderNo" type="hidden" value="" />
                      
                      </div>
                                 <div class="table-scrollable" style="white-space: nowrap;">
                                        <table class="table table-striped table-hover table-bordered">
                                        <thead>
                                        <tr class="bg-grey-steel">
                                            <th scope="col">
                                                 #
                                            </th>
                                            <th scope="col">
                                                 اسم الفحص	
                                                 <span class="font-red">
                                        		* </span>
                                            </th>
                                            <th scope="col">&nbsp;
                                                 
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>&nbsp;
                                                 
                                            </th>
                                           
                                            <th>
                                                 <select id="drpTestName" name="drpTestName"
                                                 class="form-control input-sm input-small" >
                                                        <option value="">اختر...</option>
                                                        <?php
                                                         foreach($labTests as $row)
                                                         {
                                                            echo '<option value="'.$row->test_code.'">'
                                                                    .$row->test_desc.'</option>';
                                                         }
                                                         ?>
                                                  </select>
                                            </th>
                                           
                                            
                                            <th>
                                                 <button id="btnAddTest" name="btnAddTest" type="button" 
                                                 class="btn btn-circle green-turquoise btn-sm" onclick="addTest()">
                                                <i id="iConst" class="fa fa-plus"></i></button>
                                            </th>
                                        </tr>
                                        </thead>
                                        <!--<tbody id="tbdTest">
                                         <tr>
                                               <td>  </td>
                                                
                                                <td>
                                                <td> alex </td>
                                                
                                                <td>
                                                    <a class="delete" href="javascript:;"> Delete </a>
                                                </td>
                                            </tr>
                                        </tbody>
         -->
         							<?php  /*  
		                              foreach($LabOrderTest as $row)
								  	  {
		 				
											echo "<tr>";
											echo '<td style="display:none;" id="lab_order_no'.$i.'">'. $row->lab_order_no. "</td>";
											echo '<td style="display:none;" id="test_code'.$i.'">'. $row->test_code. "</td>";
											echo '<td  id="test_desc'.$i.'">'. $row->test_desc.'</td>';
										
											echo '<td><button id="btnDeleteTest" name="btnDeleteTest" type="button" 
											class="btn btn-circle red-sunglo btn-sm" 
											onclick="deleteTestbyId('.$row->test_code.','.$row->lab_order_no.')">
															   <i id="iConst" class="fa fa-close"></i>
															   </td>';
											
											echo "</tr>";
											
											
											
										}
									*/?>
                                      	</table>
                                        <div id="dvOrderlab">
                                        </div>
                        </div>          
                  
                  </div>
                  <!-- END FORM BODY -->
                  <div class="form-actions">
                      <div class="row">
                          <div class="col-md-offset-3 col-md-9">
                              <button type="submit" class="btn blue-madison">حـفـظ</button>
                              <button type="button" class="btn default" 
                              onclick="window.location='<?php echo base_url()?>patients/';">عودة</button>
                          </div>
                      </div>
                  </div>
              </form>
          </div>
          <!-- END VALIDATION STATES-->
      </div>
  </div>
</div>
<!-- END PAGE CONTENT-->