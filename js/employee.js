// JavaScript Document

// Add Or Update User
function editemployee()
{
	var action = $("#hdnAction").val();
	//alert(action);
	$.ajax({
			url: baseURL+"Employee/"+action,
			type: "POST",
			data:  $("#employee_form").serialize(),
			error: function(xhr, status, error) {
  				//var err = eval("(" + xhr.responseText + ")");
  				//alert(xhr.responseText);
				$('#spnMsg').text('حدث خطأ أثناء عملية حفظ البانات ... الرجاء المحاولة مرة أخرى');
				var form = $('#employee_form');
				$('.alert-danger', form).show();
				$('.alert-success', form).hide();
				Metronic.scrollTo( $('.alert-danger', form), -200);
			},
			beforeSend: function(){},
			complete: function(){},
			success: function(returndb){
				if(returndb == '')
				{
					var form = $('#employee_form');
					$('.alert-success', form).show();
					$('.alert-danger', form).hide();
					Metronic.scrollTo( $('.alert-danger', form), -200);
				}
			}
		});//END $.ajax
}
function gotoEmployee(arg)
{//alert(arg);
	$.ajax({
			url: baseURL+"Employee/senddata",
			type: "POST",
			data:  {national_id : arg},
			error: function(xhr, status, error) {
  				//var err = eval("(" + xhr.responseText + ")");
  				alert(xhr.responseText);
			},
			beforeSend: function(){},
			complete: function(){},
			success: function(returndb){
				window.location.href = baseURL+"employee/empform";
				//alert(returndb);
			}
		});//END $.ajax
}
//-------------check ID ----------------------//
function check_emp_id(){	

 	var national_id = document.getElementById('txtNationalId').value;
if (national_id !='')
{
		$.ajax({
			url: baseURL+"Employee/check_id",
			type: "POST",
			data: {national_id: national_id},
			error: function(xhr, status, error) {
  				//var err = eval("(" + xhr.responseText + ")");
  				alert(xhr.responseText);
	
			},
			beforeSend: function(){},
			complete: function(){},
			success: function(result){
				
				if (result==1)
				{
					alert('رقم الهوية مستخدم مسبقاً, الرجاء التأكد من رقم الهوية المدخل');
					document.getElementById('txtNationalId').value='';
					document.getElementById('txtNationalId').focus();
					return;
				}
				
			}
		});//END $.ajax	
	
}
else
return;
}


//-------------End check ID

//--------------------------------------
var EmpFormValidation = function () {
 var handleValidation = function() {
        
            var form = $('#employee_form');
            var errormsg = $('.alert-danger', form);
            var successmsg = $('.alert-success', form);
			
            form.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "", // validate all fields including form hidden input
                rules: {
					txtNationalId: {
                        required: true
                    },
					txtEmployeeId: {
                        required: true
                    },
	                txtName: {
                        required: true
                    },
					drpJobtitle: {
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
					},
					txtEmail: {
						required: true
                    }
                },

               messages: { // custom messages for radio buttons and checkboxes
                    txtNationalId: {
						required: "الرجاء ادخال رقم الموظف"
                    },
					txtEmployeeId: {
						required: "الرجاء ادخال الرقم الوظيفي"
                    },
                    txtName: {
                        required: "الرجاء ادخل الاسم"
                    },
                    drpJobtitle: {
						required: "الرجاء ادخال المسمى الوظيفي"
                    },
					txtMobile: {
						minlength: "رقم الجوال يجب ان يكون 10 ارقام مبدوء ب 059",
						digits: "الرجـاء ادخـال ارقـام فقط",
						required: "الرجـاء ادخـال رقـم الجـوال"
                    },
					txtPhone: {
						minlength: "رقم الهاتف يجب ان يكون 7 ارقام",
						digits: "الرجـاء ادخـال ارقـام فقط"
                    },
					txtEmail: {
						required:  "الرجاء ادخال الإيميل"
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
					editemployee();
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

var EmpTableAjax = function () {

// I removed Datepicker becuse it is not used here

    var handleRecords = function () {

        var grid = new Datatable();
		
        grid.init({
            src: $("#Empdatatable_ajax"),
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
                    "url": baseURL+"Employee/employeegriddata", // ajax source
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
