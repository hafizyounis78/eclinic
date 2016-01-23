// JavaScript Document

function getValue(optnum)
{
	var constantid = $("#drpConstant"+optnum).val();
	
	if ( constantid == '')
	{
		$('#drpSubconstant'+optnum).html('<option value="">اختر...</option>');
		return;
	}
	
	$.ajax({
			url: baseURL+"Sms/getvalue",
			type: "POST",
			data: {constantid: constantid} ,
			error: function(xhr, status, error) {
  				alert(xhr.responseText);
			},
			beforeSend: function(){},
			complete: function(){},
			success: function(returndb){
				$('#drpSubconstant'+optnum).html(returndb);
				
			}
		});//END $.ajax
}

function getNum()
{
	$.ajax({
			url: baseURL+"Sms/filter",
			type: "POST",
			data: $('#sms_form').serialize(),
			error: function(xhr, status, error) {
  				alert(xhr.responseText);
			},
			beforeSend: function(){},
			complete: function(){},
			success: function(returndb){
				$("#dvFilter").css("display","block");
				
				var res = returndb.split("*");
				$('#tbElder').html(res[0]);
				$('#txtMobilenum').val(res[1]);
				
				
			}
		});//END $.ajax
}

function sendSMS()
{
	
	$.ajax({
			url: baseURL+"Sms/smsinsert",
			type: "POST",
			data: $('#sms_form').serialize(),
			
			error: function(xhr, status, error) {
  				alert(xhr.responseText);
			},
			beforeSend: function(){},
			complete: function(){},
			success: function(returndb){
				
				alert(returndb);
				
			}
		});//END $.ajax
	
}

//-------- Validation -------------------//
// File Validation
var SMSFormValidation = function () {
 var handleValidation = function() {
        	
            var form = $('#sms_form');
            var errormsg = $('.alert-danger', form);
            var successmsg = $('.alert-success', form);
			
			form.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "", // validate all fields including form hidden input
                rules: {
					txtMobilenum: {
                        required: true
					},
					txtMSG: {
                        required: true
					},
                },

               messages: { // custom messages for radio buttons and checkboxes
                    txtMobilenum: {
						required: "الرجاء ادخال رقم الجوال"
                    },
                    txtMSG: {
                        required: "الرجاء ادخال نص الرسالة"
                    },
					
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
					sendSMS();
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
//--------------------------------------