

$(document).ready(function() {
	$('#formlogin').validate({
		rules: {
			login: {
				required: true,
			},
			password: {
				required: true,
			}
		},
		messages: {
			login: {
				required: 'Please enter member name or email.'
			},
			password: {
				required: 'Please enter password.',
			}
		},
        submitHandler:submitHandlerLogin
	});
});

function submitHandlerLogin(form) {
	disableFormButton(form);
	showLoader();
	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponse,
        error: formResponseError
    });
}

function formResponse(responseText, statusText){
	var form = $('#formlogin');

	hideLoader();
	enableFormButton(form);
	
	if(statusText == 'success') {
		if(responseText.type == 'success') {
			resetForm(form);
			window.location.href = responseText.redirectUrl;
		}
		else {
			showError(responseText.caption);
			if(responseText.errorfields !== undefined) {
				highlightInvalidFields(form, responseText.errorfields);
			}
		}
	}
	else {
		showError('Unable to communicate with server.');
	}
}
