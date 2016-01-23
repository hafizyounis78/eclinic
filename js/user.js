// JavaScript Document

// Add Or Update User
function editUser()
{
	var action = $("#hdnAction").val();
	
	$.ajax({
			url: baseURL+"User/"+action,
			type: "POST",
			data:  $("#user_form").serialize(),
			error: function(xhr, status, error) {
  				//var err = eval("(" + xhr.responseText + ")");
  				//alert(xhr.responseText);
				$('#spnMsg').text('حدث خطأ أثناء عملية حفظ البانات ... الرجاء المحاولة مرة أخرى');
				var form = $('#user_form');
				$('.alert-danger', form).show();
				$('.alert-success', form).hide();
				Metronic.scrollTo( $('.alert-danger', form), -200);
			},
			beforeSend: function(){},
			complete: function(){},
			success: function(returndb){
				if(returndb == '')
				{
					var form = $('#user_form');
					$('.alert-success', form).show();
					$('.alert-danger', form).hide();
					Metronic.scrollTo( $('.alert-success', form), -200);
				}
				
				
			}
		});//END $.ajax
}
function gotoUser(arg)
{
	$.ajax({
			url: baseURL+"User/senddata",
			type: "POST",
			data:  {username : arg},
			error: function(xhr, status, error) {
  				//var err = eval("(" + xhr.responseText + ")");
  				alert(xhr.responseText);
			},
			beforeSend: function(){},
			complete: function(){},
			success: function(returndb){
				window.location.href = baseURL+"user/userform";
				//alert(returndb);
			}
		});//END $.ajax
}
function updateUserstatus(username)
{
	var isactive = '';
	var newclass = '';
	var itemid = '#i'+username;
	var active_class = 'fa fa-user font-green';
	var unactive_class = 'fa fa-user font-red-sunglo';
	
	if($('#i'+username).attr("class") == active_class)
	{
		isactive = 0;
		newclass = unactive_class;
	}
	else
	{
		isactive = 1;
		newclass = active_class;
	}
	
	$.ajax({
			url: baseURL+"User/updateacount",
			type: "POST",
			data:  {username : username,
					isactive : isactive},
			error: function(xhr, status, error) {
  				//var err = eval("(" + xhr.responseText + ")");
  				alert(xhr.responseText);
			},
			beforeSend: function(){},
			complete: function(){},
			success: function(returndb){
				if (returndb == '')	//Success
				{
					$('#i'+username).removeClass( $('#i'+username).attr("class") ).addClass(newclass);
				}
			}
		});//END $.ajax
	
}
function resetPassword(username)
{
	$.ajax({
			url: baseURL+"User/resetpassword",
			type: "POST",
			data:  {username : username},
			error: function(xhr, status, error) {
  				//var err = eval("(" + xhr.responseText + ")");
  				alert(xhr.responseText);
			},
			beforeSend: function(){},
			complete: function(){},
			success: function(returndb){
				if(returndb == '')
					alert('تم تعديل كلمة المرور الى 123456');
				else
					alert('حدث خطأ أثناء عملية التعديل');
			}
		});//END $.ajax
}

$(document).ready(function(){
	// Conferm Reset Password						   
	$('#confirm-reset').on('show.bs.modal', function(e) {
		$(this).find('.btn-ok').attr('onclick', $(e.relatedTarget).data('onclick'));
	});
	
	// Prevent Arabic Char In Username
	$("#txtUsername").on("keypress", function(event) {
		  var englishAlphabetAndWhiteSpace = /[ا-ي]/g;
		  var key = String.fromCharCode(event.which);
		  if (englishAlphabetAndWhiteSpace.test(key)) {
			 return false;
		  }
	});
	
}); // END READY

//--------------------------------------
var UserFormValidation = function () {
 var handleValidation = function() {
        	
            var form = $('#user_form');
            var errormsg = $('.alert-danger', form);
            var successmsg = $('.alert-success', form);
			
            // Unique Username
			var response = true;
			$.validator.addMethod(
				"uniqueUserName", 
				function(value, element) {
					if ($("#hdnAction").val() == 'updateuser')
					{
						return true;
					}
					$.ajax({
						type: "POST",
						url: baseURL+"User/availabileusername",
						data: {username :value},
						error: function(xhr, status, error) {
							//var err = eval("(" + xhr.responseText + ")");
							alert(xhr.responseText);
						},
						beforeSend: function(){},
						complete: function(){},
						success: function(msg)
						{
							var massege ='';
							if( msg == 'true' )
							{
								$("#iCheck").removeClass('fa fa-warning font-red-sunglo').addClass('fa fa-check font-green');
								$("#txtUsername").closest('.form-group').removeClass('has-error').addClass('has-success');
								$("#txtUsername-error").html('اسم المستخدم <b>' + value + '</b> متاح. يمكنك اختياره!');
								
								response = true;
							}
							else
							{
								$("#iCheck").removeClass('fa fa-check font-green').addClass('fa fa-warning font-red-sunglo');
								$("#txtUsername").closest('.form-group').removeClass('has-success').addClass('has-error');
								$("#txtUsername-error").html('اسم المستخدم <b>' + value + '</b> غير متاح. الرجاء اختيار اسم مستخدم اخر!');
								response = false;
								
							}
							
							
						}
						
					 });//END $.ajax
					return response;
				},
				"Username is Already Taken"
			);
			
			form.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "", // validate all fields including form hidden input
                rules: {
					txtEmployeeId: {
                        required: true
                    },
                    txtName: {
                        required: true
                    },
					txtUsername: {
						minlength: 2,
                        required: true,
						uniqueUserName: true
                    },
					txtPassword: {
						minlength: 6,
                        required: true
                    },
					txtPasswordconf: {
                        required: true,
						equalTo: "#txtPassword"
                    },
					drpUsertype: {
						required: true
                    }
                },

               messages: { // custom messages for radio buttons and checkboxes
                    txtEmployeeId: {
						required: "الرجاء ادخل رقم الموظف"
                    },
                    txtName: {
                        required: "الرجاء ادخل اسم"
                    },
					txtUsername: {
                        minlength: "لايمكن ادخال اسـم المستـخدم اقل من حرفين",
						required: "الرجـاء ادخـل اسـم المستـخدم",
						uniqueUserName: "اسم المستخدم غير متاح ... الرجاء اختيار اسم مستخدم اخر"
                    },
					txtPassword: {
						minlength: "كلمة المرور يجب ان لا تقل عن 6 خانات",
                        required: "الـجاء ادخـل كلمــة المـرور"
                    },
					txtPasswordconf: {
                        required: "الـجاء ادخـل تأكيـد كلمـة المـرور",
						equalTo: "الكلمة غير مطابقة لكلمة المرور"
                    },
					drpUsertype: {
                        required: "الـجاء ادخـل نوع المستخدم"
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
				   	
					if($(element).attr('id') == 'txtUsername')
						$("#iCheck").removeClass('fa fa-check font-green').addClass('fa fa-warning font-red-sunglo');
								
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
					editUser();
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

/*-----------------------------------------------------*/
/*	Data Grid Section								   */
/*	Ajax Data Table Jquery							   */
/*													   */
/*-----------------------------------------------------*/

var UserTableAjax = function () {

// I removed Datepicker becuse it is not used here

    var handleRecords = function () {

        var grid = new Datatable();
		
        grid.init({
            src: $("#datatable_ajax"),
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
                    "url": baseURL+"User/usergriddata", // ajax source
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
//----------------------------------------------------------
var ComponentsFormTools = function () {

    var handleTwitterTypeahead = function() {

        var custom = new Bloodhound({
          datumTokenizer: function(d) { return d.tokens; },
          queryTokenizer: Bloodhound.tokenizers.whitespace,
          remote: {
						url: baseURL+'User/getemp/%QUERY',
						filter: function (custom) {
							return $.map(custom, function (emp) {
								$('#txtEmployeeId').val('');
								return {
									value: emp.name,
									id: emp.employee_id,
									empid: emp.emp_id
									
								};
							});
						},
					}
        });
         
        custom.initialize();
         
        if (Metronic.isRTL()) {
          $('#txtName').attr("dir", "rtl");  
        }  
        $('#txtName').typeahead(null, {
          name: 'txtName',
          displayKey: 'value',
          source: custom.ttAdapter(),
          
        }).on('typeahead:selected typeahead:autocompleted typeahead:cursorchanged', function(event, datum) {
         $('#hdnEmployeeId').val(datum.id);
		 $('#txtEmpId').val(datum.empid);
		 });
		
    }
	// Check Username Availability
	/*var handleUsernameAvailabilityChecker = function () {
        $("#txtUsername").change(function () {
            var input = $(this);
			
            if (input.val() === "") {
                return;
            }

            input.attr("readonly", true).
            attr("disabled", true).
            addClass("spinner");

            $.post(baseURL+"User/availabileusername", {
                username: input.val()
            }, function (res) {
                input.attr("readonly", false).
                attr("disabled", false).
                removeClass("spinner");

                // change popover font color based on the result
                if (res.status == 'OK') {
					alert('OK');
                    input.closest('.form-group').removeClass('has-error').addClass('has-success');
                    $('.icon-exclamation-sign', input.closest('.form-group')).remove();
                    input.before('<i class="icon-ok"></i>');
                    input.data('bs.popover').tip().removeClass('error').addClass('success');
                } else {
					alert('Error');
                    input.closest('.form-group').removeClass('has-success').addClass('has-error');
                    $('.icon-ok', input.closest('.form-group')).remove();
                    input.before('<i class="icon-exclamation-sign"></i>');

                    input.popover('destroy');
                    input.popover({
                        'html': true,
                        'placement': (Metronic.isRTL() ? 'left' : 'right'),
                        'container': 'body',
                        'content': res.message,
                    });
                    input.popover('show');
                    input.data('bs.popover').tip().removeClass('success').addClass('error');

                    Metronic.setLastPopedPopover(input);
                }

            }, 'json');

        });
    }*/
	return {
        //main function to initiate the module
        init: function () {
            handleTwitterTypeahead();
			//handleUsernameAvailabilityChecker();
		}
    };

}();