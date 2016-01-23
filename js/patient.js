


//************* Governate change ******************//
function governorate_change(){	

 	var governorate_code = $('#drpGovernorate').find('option:selected').val();
	
	$.ajax({
			url: baseURL+"Surveycont/get_region",
			type: "POST",
			data:  {governorateCode:governorate_code},
			error: function(xhr, status, error) {
  				alert(xhr.responseText);
			},
			beforeSend: function(){},
			complete: function(){},
			success: function(returndb){
				var i=0;
				$('#drpRegion').empty();
				$('#drpFulladdress').empty();
//				alert(returndb[0]['sub_constant_id']+returndb[0]['sub_constant_name']);
				$('#drpRegion').append("<option>أختر ....</option>");
				for (i=0;i<returndb.length;++i)
			//	alert(returndb[i]['sub_constant_id']+returndb[i]['sub_constant_name']);
				$('#drpRegion').append('<option value= "'+ returndb[i]['sub_constant_id'] + '">' + returndb[i]['sub_constant_name'] +'</option>');
				
			}
		});//END $.ajax
}
//************* region change ******************//
function region_change(){	

 	var region_code = $('#drpRegion').find('option:selected').val();
	
	$.ajax({
			url: baseURL+"Surveycont/get_fulladdress",
			type: "POST",
			data:  {regionCode:region_code},
			error: function(xhr, status, error) {
  				alert(xhr.responseText);
			},
			beforeSend: function(){},
			complete: function(){},
			success: function(returndb){
				var i=0;
				$('#drpFulladdress').empty();
//				alert(returndb[0]['sub_constant_id']+returndb[0]['sub_constant_name']);
				$('#drpFulladdress').append("<option>أختر ....</option>");
				for (i=0;i<returndb.length;++i)
			//	alert(returndb[i]['sub_constant_id']+returndb[i]['sub_constant_name']);
				$('#drpFulladdress').append('<option value= "'+ returndb[i]['sub_constant_id'] + '">' + returndb[i]['sub_constant_name'] +'</option>');
				
			}
		});//END $.ajax
}
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
		
		$('#lblAge').html('<b> عمر العضو : <span id="spnAge">'+age+'</span></b>');
		if (age >= 60)
		{
			$('#lblAge').removeClass('font-red').addClass('font-green');
		}
		else
		{
			$('#lblAge').removeClass('font-green').addClass('font-red');
		}
}

//********************Patient edit***********//
function editePatient()
{
	var action = $("#hdnAction").val();
		alert(action);
						
	$.ajax({
			url: baseURL+"Surveycont/"+action,
			type: "POST",
			data:  $("#Patient_form").serialize(),
			error: function(xhr, status, error) {
				
				alert(xhr.responseText);
			},
			beforeSend: function(){},
			complete: function(){},
			success: function(returndb){
				if(returndb != 0)
				{
					//$("#hdnSurveyId").val(returndb['survey_id']);
					$("#hdnFileId")  .val(returndb['patient_file_id']);
					
					$("#hdnAction").val('updatepatient');
					
				}
			}
		});//END $.ajax
	
}
//****************Patient Validation
var PatientFormValidation = function () {
 var handleValidation = function() {
        
            var form = $('#Patient_form');
            var errormsg = $('.alert-danger', form);
            var successmsg = $('.alert-success', form);
			
            form.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "", // validate all fields including form hidden input
                rules: {
					
					txtFname: {
                        required: true
                    },
	                txtMname: {
                        required: true
                    },
					txtThname: {
                        required: true
                    },
	                txtLname: {
                        required: true
                    },
					dpDob: {
                        required: true,
						greaterThanSixty : true
                    },
					drpStatus: {
                        required: true
                    },
					drpGovernorate: {
                        required: true
                    },
					drpRegion: {
                        required: true
                    },
					drpFulladdress: {
                        required: true
					},
					txtMobile: {
						digits: true,
						minlength: 10,
						required: true
                    },
					txtPhone: {
                       digits: true,
						minlength: 7
					}
				},

               messages: { // custom messages for radio buttons and checkboxes
                txtFname: {
                        required: "الرجاء ادخل الاسم"
                    },
                    txtMname: {
                        required: "الرجاء ادخل الاسم"
                    }
					,
                    txtThname: {
                        required: "الرجاء ادخل الاسم"
                    }
					,
                    txtLname: {
                        required: "الرجاء ادخل الاسم"
                    },
					dpDob: {
						required: "الرجاء إدخال تاريخ الميلاد",
						greaterThanSixty: "عمر العضو يجب ان يكون أكبر من 60 سنة"
                    },
					drpElderstatus: {
						required: "الرجاء إختيار قيمة"
                    },
					drpGovernorate: {
						required: "الرجاء إختيار قيمة"
                    },
					drpRegion: {
						required: "الرجاء إختيار قيمة"
                    },
					drpFulladdress: {
						required: "الرجاء إختيار قيمة"
                    },
					txtMobile: {
						minlength: "رقم الجوال يجب ان يكون 10 ارقام مبدوء ب 059",
						digits: "الرجـاء ادخـال ارقـام فقط",
						required: "الرجـاء ادخـال رقـم الجـوال"
                    },
					txtPhone: {
						minlength: "رقم الهاتف يجب ان يكون 7 ارقام",
						digits: "الرجـاء ادخـال ارقـام فقط"
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
					editePatient();
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