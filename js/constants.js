// JavaScript Document

$(document).ready(function(){
	$('#btnAddconstant').click(function(event) {							
		event.preventDefault();
		
		//-- Validation
		$('#dvConstSuccessMsg').attr('class', 'alert alert-success display-hide');
		$('#dvConstErrorMsg')  .attr('class', 'alert alert-danger  display-hide');
		$('#dvSubSuccessMsg')  .attr('class', 'alert alert-success display-hide');
		$('#dvSubErrorMsg')    .attr('class', 'alert alert-danger  display-hide');
				
		if($.trim($('#txtConstantName').val()) == '')
		{
			$('#dvConstErrorMsg').attr('class', 'alert alert-danger');
			$('#txtConstantName').focus();
			return;
		}
		//--
		
		var action = 'addconstants';
		if($('#hdnConstantid').val() != '')
			action = 'updateconstants';
		
		$.ajax({
			url: baseURL+"Constant/"+action,
			type: "POST",
			data:  $("#constant_form").serialize(),
			error: function(xhr, status, error) {
  				//var err = eval("(" + xhr.responseText + ")");
  				alert(xhr.responseText);
			},
			beforeSend: function(){},
			complete: function(){},
			success: function(returndb){
				$('#dvConstSuccessMsg').attr('class', 'alert alert-success');
				$('#tbdConst').html(returndb);
				if (action == 'addconstants')
					$('#txtConstantName').val('');
			}
		});//END $.ajax
	}); // END CLICK

	$('#btnAddsub').click(function(event) {							
		event.preventDefault();
		
		//-- Validation
		$('#dvConstSuccessMsg').attr('class', 'alert alert-success display-hide');
		$('#dvConstErrorMsg')  .attr('class', 'alert alert-danger  display-hide');
		$('#dvSubSuccessMsg')  .attr('class', 'alert alert-success display-hide');
		$('#dvSubErrorMsg')    .attr('class', 'alert alert-danger  display-hide');
			
		if($.trim($('#txtSubConstantName').val()) == '')
		{
			$('#dvSubErrorMsg').attr('class', 'alert alert-danger');
			$('#txtSubConstantName').focus();
			return;
		}
		//--
		
		var action = 'addsubconstant';
		if($('#hdnSubConstid').val() != '')
			action = 'updatesubconstant';
		
		$.ajax({
			url: baseURL+"Constant/"+action,
			type: "POST",
			data:  $("#constant_form").serialize(),
			error: function(xhr, status, error) {
  				alert(xhr.responseText);
			},
			beforeSend: function(){},
			complete: function(){},
			success: function(returndb){
				$('#dvSubSuccessMsg').attr('class', 'alert alert-success');
				$('#tbdSub').html(returndb);
				$('#txtSubConstantName').val('');
				$('#hdnSubConstid').val('');
				$('#iSub').attr('class', 'fa fa-plus');
			}
		});//END $.ajax
	}); // END CLICK
	
}); // END READY
//******************************************
function show_sub(constantid,constantname)
{
	$('#dvConstSuccessMsg').attr('class', 'alert alert-success display-hide');
	$('#dvConstErrorMsg')  .attr('class', 'alert alert-danger  display-hide');
	$('#dvSubSuccessMsg')  .attr('class', 'alert alert-success display-hide');
	$('#dvSubErrorMsg')    .attr('class', 'alert alert-danger  display-hide');
	
	$('#iConst').attr('class', 'fa fa-edit');
	
	$('#hdnConstantid').val(constantid);
	$('#txtConstantName').val(constantname);
	$.ajax({
			url: baseURL+"Constant/showsubconstant",
			type: "POST",
			data: {constantid: constantid} ,
			error: function(xhr, status, error) {
  				alert(xhr.responseText);
			},
			beforeSend: function(){},
			complete: function(){},
			success: function(returndb){
				$("#dvSub").css({ display: "block" });
				$('#tbdSub').html(returndb);
				
			}
		});//END $.ajax
}
function show_edit_sub(subconstantid,subconstantname)
{
	$('#hdnSubConstid').val(subconstantid);
	$('#txtSubConstantName').val(subconstantname);
	$('#iSub').attr('class', 'fa fa-edit');
	
	$('#dvConstSuccessMsg').attr('class', 'alert alert-success display-hide');
	$('#dvConstErrorMsg')  .attr('class', 'alert alert-danger  display-hide');
	$('#dvSubSuccessMsg')  .attr('class', 'alert alert-success display-hide');
	$('#dvSubErrorMsg')    .attr('class', 'alert alert-danger  display-hide');
	
}
function reload_constant_form()
{
	$('#hdnConstantid').val('');
	$('#txtConstantName').val('');
	$('#iConst').attr('class', 'fa fa-plus');
	
	$('#hdnSubConstid').val('');
	$('#txtSubConstantName').val('');
	$('#iSub').attr('class', 'fa fa-plus');
	
	$('#tbdSub').html('');
	$("#dvSub").css({ display: "none" });
	
	$('#dvConstSuccessMsg').attr('class', 'alert alert-success display-hide');
	$('#dvConstErrorMsg')  .attr('class', 'alert alert-danger  display-hide');
	$('#dvSubSuccessMsg')  .attr('class', 'alert alert-success display-hide');
	$('#dvSubErrorMsg')    .attr('class', 'alert alert-danger  display-hide');
			
}
