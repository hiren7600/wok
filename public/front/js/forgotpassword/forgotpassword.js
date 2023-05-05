

$(document).ready(function() {

	$('#formforgot').validate({
		rules: {
			username: {
				required: true,
			}
		},
		messages: {
			username: {
				required: 'Please enter member name/email address.',
			}
		},
        submitHandler:submitHandlerforgot
	});
});

function submitHandlerforgot(form) {
	disableFormButton(form);
	showLoader();
	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponse,
        error: formResponseError
    });
}

function formResponse(responseText, statusText){
	var form = $('#formforgot');

	hideLoader();
	enableFormButton(form);
	if(statusText == 'success') {
        console.log(responseText.redirect_url == 'success');
		if(responseText.type == 'success') {
			resetForm(form);
			showSuccess(responseText.caption);
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
