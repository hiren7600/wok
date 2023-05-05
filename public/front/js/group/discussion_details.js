$(document).ready(function(){

	$('.btn-request-group').click(function(){
		$('#requestgroup_form').submit();
	});

	$('.btn-join-group').click(function(){
		$('#joingroup_form').submit();
	});


	$('#requestgroup_form').validate({
		submitHandler: submitHandlerRequestGroup
	});

	$('#joingroup_form').validate({
		submitHandler: submitHandlerJoinGroup
	});

    $('#delete_group_form').validate({
		submitHandler: submitHandlerDeleteGroup
	});

	$('.btn-delete-group').click(function(e){
		e.preventDefault();

		confirmDialoue("Delete", 'Are you sure you want to delete this group?', function(e){
			if (e) {
				$('#delete_group_form').submit();
			}
			else {
				hideModal();
			}
		});
	});

});

function submitHandlerRequestGroup(form) {
	disableFormButton(form);
	showLoader();
	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseRequestGroup,
        error: formResponseError
    });
}

function formResponseRequestGroup(responseText, statusText){
	var form = $('#requestgroup_form');
	hideLoader();
	enableFormButton(form);

	if(statusText == 'success') {
		if(responseText.type == 'success') {
			refreshPage();
			// if(responseText.requesttype == 'join-request') {
	  //           $('.btn-request-group').addClass('leave').text('Cancel Join Group Request');
			// }
			// else {
			// 	$('.btn-request-group').removeClass('leave').text('Request to Join Group');
			// }
		}
		else {
			showError(responseText.caption, responseText.errormessage);
			if(responseText.errorfields !== undefined) {
				highlightInvalidFields(form, responseText.errorfields);
			}
		}
	}
	else {
		showError(getTranslation('Unable to communicate with server.'));
	}
}

function submitHandlerJoinGroup(form) {
	disableFormButton(form);
	showLoader();
	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseJoinGroup,
        error: formResponseError
    });
}


function formResponseJoinGroup(responseText, statusText){
	var form = $('#joingroup_form');
	hideLoader();
	enableFormButton(form);

	if(statusText == 'success') {
		if(responseText.type == 'success') {
			refreshPage();
			// if(responseText.requesttype == 'group-join') {
	  //           $('.btn-join-group').addClass('leave').text('Leave Group');
			// }
			// else {
			// 	$('.btn-join-group').removeClass('leave').text('Join Group');
			// }
		}
		else {
			showError(responseText.caption, responseText.errormessage);
			if(responseText.errorfields !== undefined) {
				highlightInvalidFields(form, responseText.errorfields);
			}
		}
	}
	else {
		showError(getTranslation('Unable to communicate with server.'));
	}
}
function submitHandlerDeleteGroup(form) {
	disableFormButton(form);
	showLoader();
	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseDeleteGroup,
        error: formResponseError
    });
}

function formResponseDeleteGroup(responseText, statusText){
	var form = $('#delete_group_form');
	hideLoader();
	enableFormButton(form);

	if(statusText == 'success') {
		if(responseText.type == 'success') {
			window.location.href = responseText.redirectUrl;
		}
		else {
			showError(responseText.caption, responseText.errormessage);
			if(responseText.errorfields !== undefined) {
				highlightInvalidFields(form, responseText.errorfields);
			}
		}
	}
	else {
		showError(getTranslation('Unable to communicate with server.'));
	}
}

