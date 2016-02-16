


//************* Governate change ******************//
function calculat_bmi()
{
	
	var wieght=$('#txtWeight').val();				
	var length=$('#txtLength').val();				
	if (wieght != '' && length != '')
		{
			
			var bmi=parseFloat(wieght)/(parseFloat(length)*parseFloat(length));
			bmi = Math.round(bmi * 100) / 100
			$('#txtBmi').val(bmi);	
			
		}
				
}

function drpplan_change(){	

 	var plan_code = $('#drpPlan').find('option:selected').val();
	//alert(plan_code);
	$.ajax({
			url: baseURL+"Visitcont/get_nut_plan",
			type: "POST",
			data:  {planCode:plan_code},
			error: function(xhr, status, error) {
  				alert(xhr.responseText);
			},
			beforeSend: function(){},
			complete: function(){},
			success: function(returndb){
			//alert(returndb);	
			$('#txtbreakfast').val(returndb[0]['breakfast']);				
			$('#txtlunch').val(returndb[0]['lunch']);				
			$('#txtdinner').val(returndb[0]['dinner']);				
			}
		});//END $.ajax
}
//************* region change ******************//

// Calculate Age 
function claculateAge()
{
	if($('#dpDob').val() == '')
	{
		$('#lblAge').html('');
		$('#lblAge').removeClass('font-red');
		$('#lblAge').removeClass('font-green');
		return;
	}
	
		var dateStr = $('#dpDob').val();
		var dateParts = dateStr.split("-");
		var dateOfBirth = new Date(dateParts[0], (dateParts[1] - 1), dateParts[2]);
		
		var dateToCalculate = new Date();
		var calculateYear = dateToCalculate.getFullYear();
    	var calculateMonth = dateToCalculate.getMonth();
    	var calculateDay = dateToCalculate.getDate();
		
		var birthYear = dateOfBirth.getFullYear();
    	var birthMonth = dateOfBirth.getMonth();
    	var birthDay = dateOfBirth.getDate();
		
		var age = calculateYear - birthYear;
    	var ageMonth = calculateMonth - birthMonth;
    	var ageDay = calculateDay - birthDay;
		
		if (ageMonth < 0 || (ageMonth == 0 && ageDay < 0)) {
        	age = parseInt(age) - 1;
    	}
		
		$('#lblAge').html('<b> عمر المريض : <span id="spnAge">'+age+'</span></b>');
		/*if (age >= 60)
		{
			$('#lblAge').removeClass('font-red').addClass('font-green');
		}
		else*/
		{
			$('#lblAge').removeClass('font-green').addClass('font-red');
		}
}

//********************Patient edit***********//
function editeVisits()
{
	var action = $("#hdnvAction").val();
	//	alert(action);
						
	$.ajax({
			url: baseURL+"Visitcont/"+action,
			type: "POST",
			data:  $("#Visit_form").serialize(),
			error: function(xhr, status, error) {
				
				alert(xhr.responseText);
			},
			beforeSend: function(){},
			complete: function(){},
			success: function(returndb){
				//if(returndb != 0)
				{
					//alert(returndb['patient_file_id']);
					//$("#hdnSurveyId").val(returndb['survey_id']);
					
					
						$("#hdnvisitNo")  .val(returndb['visit_id']);
					
					$("#hdnvAction").val('updatevisit');
					
					var form = $('#Visit_form');
					$('.alert-success', form).show();
					$('.alert-danger', form).hide();
					Metronic.scrollTo( $('.alert-danger', form), -200);
					
				}
			}
		});//END $.ajax
	
}
//*************end visit
function endVisit(){	
	
var visitNo=$("#hdnvisitNo").val();
	$.ajax({
			url: baseURL+"Visitcont/endPatientVisit",
			type: "POST",
			data: {hdnvisitNo:visitNo},
			error: function(xhr, status, error) {
  				alert(xhr.responseText);
			},
			beforeSend: function(){},
			complete: function(){},
			success: function(returndb){
			
					var form = $('#Patient_form');
					$('.alert-success', form).show();
					$('.alert-danger', form).hide();
					Metronic.scrollTo( $('.alert-danger', form), -200);
						window.location.href = baseURL+"patientcont/patientlist";
			}
		});//END $.ajax
}
//*************end Visit function
function addTest()
{
	//var action = $("#hdnActionFM").val();
	//alert(action);
	
	/*if ( !validateFamilymember() )
		return;*/
		
	// Create a new FormData object.
	var formData = new FormData();
	
	// Add the data to the request.
	formData.append('hdnvisitNo'		 , $("#hdnvisitNo").val()		  );
	formData.append('txtPatientFileId'		 , $("#txtPatientFileId").val()		  );
	formData.append('dpVisitdate'		 ,  $("#dpVisitdate").val()		  );
	formData.append('drpVisitType'	  	 ,  $("#drpVisitType").val()	  );
	formData.append('drpTestName'	  	 ,  $("#drpTestName").val()	  );
	formData.append('hdnCountLabOrder'	  	 ,  $("#hdnCountLabOrder").val()	  );
	formData.append('hdnLabOrderNo'	  	 ,  $("#hdnLabOrderNo").val()	  );
	

	$.ajax({
			url: baseURL+"Visitcont/addtest",
			type: "POST",
			data:  formData,
			processData: false,
    		contentType: false,
			error: function(xhr, status, error) {
  				alert(xhr.responseText);
			},
			beforeSend: function(){},
			complete: function(){},
			success: function(returndb){
			//	alert(returndb);
				var res = returndb.split("#$#");
				$('#hdnLabOrderNo').val(res[0]);
				$('#accordion2 > tbody:last-child').append(res[1]);
				var count = parseInt($("#hdnCountLabOrder").val());
				$("#hdnCountLabOrder").val(count+1)
			//	$("#hdnLabOrderNo").val(returndb);
				/*var countFM = parseInt($("#spnCountFamily").html());;
				countFM = countFM + 1;
				$("#spnCountFamily").html(countFM);
				
				$("#tbdFamilyMember").html(returndb);
				clearFamilymemberFields();*/
				/*if(returndb == '')
				{
					var form = $('#familyMemberTab');
					$('.alert-success', form).show();
					//$('#hdnAction').val('');
				}*/
			}
		});//END $.ajax
}
function addResult(resultid)
{
	//alert("resultid="+resultid);
	//alert("Value="+$('#txt'+resultid).val());
	var itemValue=$('#txt'+resultid).val();
	$.ajax({
			url: baseURL+"Visitcont/addTestResult",
			type: "POST",
			data:  {resultid : resultid,
					itemValue : itemValue},
			error: function(xhr, status, error) {

  				alert(xhr.responseText);
			},
			beforeSend: function(){},
			complete: function(){},
			success: function(returndb){
				//alert(111);
				//alert(returndb);
				
	
			}
		});//END $.ajax

}
function gotoUpdateVisit(arg)
{//alert(arg);
	$.ajax({
			url: baseURL+"Visitcont/getvisstdata",
			type: "POST",
			data:  {VisitNo : arg},
			error: function(xhr, status, error) {
  				//var err = eval("(" + xhr.responseText + ")");
  				alert(xhr.responseText);
			},
			beforeSend: function(){},
			complete: function(){},
			success: function(returndb){
				//alert(111);
				//alert(returndb);
				window.location.href = baseURL+"visitcont/visitform";
				
/*				
				//$("#txtPatientFileId").val(returndb[0]['patient_file_id']);

				$("#txtpatientName").val(returndb[0]['name']);
				$("#dpDob").val(returndb[0]['dob']);
				$("#dpVisitdate")  .val(returndb[0]['visit_date']);
				$("#txtVisittime")  .val(returndb[0]['visit_time']);
				$("#drpVisitType")  .val(returndb[0]['visit_type_id']);

				$("#txtLength")  .val(returndb[0]['length']);
				$("#txtWeight")  .val(returndb[0]['weight']);
				$("#txtBmi")  .val(returndb[0]['bmi']);

				$("#drpPlan")  .val(returndb[0]['plan_id']);
				$("#dpStartdate")  .val(returndb[0]['start_date']);
				$("#dpEnddate")  .val(returndb[0]['end_date']);
				$("#txtbreakfast")  .val(returndb[0]['break_fast']);
				$("#txtlunch")  .val(returndb[0]['lunch']);
				$("#txtdinner")  .val(returndb[0]['dinner']);
				$("#txtNotes")  .val(returndb[0]['notes']);
				$("#hdnvAction").val('updatevisit');
				
	*/			
				//alert(returndb);
			}
		});//END $.ajax
}

//****************Patient Validation
var VisitFormValidation = function () {
 var handleValidation = function() {
        
            var form = $('#Visit_form');
            var errormsg = $('.alert-danger', form);
            var successmsg = $('.alert-success', form);
			
            form.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "", // validate all fields including form hidden input
                rules: {
					
					drpVisitType: {
                        required: true
                    },
	                txtWeight: {
                        required: true,
						digits: true
                    },
					txtLength: {
                        required: true
                    },
	                drpPlan: {
                        required: true
                    },
                    dpStatdate: {
						required: true
						
                    },
                    dpEnddate: {
                      required: true
						
                    },
                    txtbreakfast: {
                       required: true
					},
                    txtlunch: {
                        required: true
						
                    },
                    txtdinner: {
                        required: true
						
                    }
				},

               messages: { // custom messages for radio buttons and checkboxes
                	drpVisitType: {
                    required: "الرجاء إختيار قيمة"
                    
                    },
                    txtWeight: {
                        required: "الرجاء ادخل الاسم",
						digits: "الرجـاء ادخـال ارقـام فقط"
                    }
					,
                    txtLength: {
                        required: "الرجاء ادخل الاسم",
						digits: "الرجـاء ادخـال ارقـام فقط"
                    },
					drpPlan: {
						required: "الرجاء إختيار قيمة"
                    },
                    dpStatdate: {
                        required: "الرجاء ادخل تاريخ"
						
                    },
                    dpEnddate: {
                        required: "الرجاء ادخل تاريخ"
						
                    },
                    txtbreakfast: {
                       required: "الرجاء ادخل قيمة"
					},
                    txtlunch: {
                        required: "الرجاء ادخل قيمة"
                    },
                    txtdinner: {
                        required: "الرجاء ادخل قيمة"
                    }
					
                },

                errorPlacement: function (error, element) { // render error placement for each input type
                    if (element.attr("data-error-container")) { 
                        error.appendTo(element.attr("data-error-container"));
                    } else if (element.parent(".input-group").size() > 0) {
                        error.insertAfter(element.parent(".input-group"));
                    } else if (element.parents('.radio-list').size() > 0) { 
                        error.appendTo(element.parents('.radio-list').attr("data-error-container"));
                    } else if (element.parents('.radio-inline').size() > 0) { 
                        error.appendTo(element.parents('.radio-inline').attr("data-error-container"));
                    } else if (element.parents('.checkbox-list').size() > 0) {
                        error.appendTo(element.parents('.checkbox-list').attr("data-error-container"));
                    } else if (element.parents('.checkbox-inline').size() > 0) { 
                        error.appendTo(element.parents('.checkbox-inline').attr("data-error-container"));
                    } else {
                        error.insertAfter(element); // for other inputs, just perform default behavior
                    }
                },

                invalidHandler: function (event, validator) { //display error alert on form submit   
                    successmsg.hide();
                    errormsg.show();
					$('#spnMsg').text('يـوجد بـعـض الادخـالات الخـاطئة، الرجـاء التأكد من القيم المدخلة');
                    Metronic.scrollTo(errormsg, -200);
                },

                highlight: function (element) { // hightlight error inputs
                   $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
                },

                success: function (label) {
                    label
                        .closest('.form-group').removeClass('has-error'); // set success class to the control group
                },

                submitHandler: function (form) {
                    errormsg.hide();
					editeVisits();
                    //form[0].submit(); // submit the form
                }

            });
    }
return {
        //main function to initiate the module
        init: function () {
            handleValidation();

        }

    };

}();

//************* patient Ajax**************//
var VisitTableAjax = function () {

// I removed Datepicker becuse it is not used here

    var handleRecords = function () {

        var grid = new Datatable();
		
        grid.init({
            src: $("#Visitdatatable_ajax"),
            onSuccess: function (grid) {
                // execute some code after table records loaded
				//alert(grid);
            },
            onError: function(xhr, status, error) {
  				//alert(xhr.responseText);
			},
            loadingMessage: 'جاري تحميل البيانات...',
            dataTable: { // here you can define a typical datatable settings from http://datatables.net/usage/options 

                // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
                // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/scripts/datatable.js). 
                // So when dropdowns used the scrollable div should be removed. 
                //"dom": "<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'<'table-group-actions pull-right'>>r>t<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'>>",
                
                "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.

                "lengthMenu": [
                    [10, 20, 50, 100, 150, -1],
                    [10, 20, 50, 100, 150, "All"] // change per page values here
                ],
                "pageLength": 10, // default record count per page
                "ajax": {
                    "url": baseURL+"Visitcont/visitsgriddata", // ajax source
					"type": "POST"
                },
                "order": [
                    [1, "asc"]
                ] // set first column as a default sort by asc
            }
        });

        // handle group actionsubmit button click
        grid.getTableWrapper().on('click', '.table-group-action-submit', function (e) {
            e.preventDefault();
            var action = $(".table-group-action-input", grid.getTableWrapper());
            if (action.val() != "" && grid.getSelectedRowsCount() > 0) {
                grid.setAjaxParam("customActionType", "group_action");
                grid.setAjaxParam("customActionName", action.val());
                grid.setAjaxParam("id", grid.getSelectedRows());
                grid.getDataTable().ajax.reload();
                grid.clearAjaxParams();
            } else if (action.val() == "") {
                Metronic.alert({
                    type: 'danger',
                    icon: 'warning',
                    message: 'Please select an action',
                    container: grid.getTableWrapper(),
                    place: 'prepend'
                });
            } else if (grid.getSelectedRowsCount() === 0) {
                Metronic.alert({
                    type: 'danger',
                    icon: 'warning',
                    message: 'No record selected',
                    container: grid.getTableWrapper(),
                    place: 'prepend'
                });
            }
        });
    }
	
    return {

        //main function to initiate the module
        init: function () {

            //initPickers();
            handleRecords();
			
        }

    };

}();