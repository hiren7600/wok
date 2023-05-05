$(document).ready(function() {

	$('#formcontactus').validate({
		rules: {
			name: {
				required: true,
                minlength: 2,
				maxlength: 24,
			},
			email: {
				required: true,
				email: true,
				minlength: 10,
				maxlength: 40
			},
            subject: {
				required: true
			},
            message: {
				required: true
			}
		},
		messages: {
			name: {
				required: 'Please enter name.',
				minlength: 'Please enter name at least 2 characters long.',
				maxlength: 'Please enter name at least 40 characters or less.',
			},
			email: {
				required: 'Please enter email address.',
				email: 'Please enter a valid email address.',
				minlength: 'Please enter email at least 10 characters long.',
				maxlength: 'Please enter email at least 40 characters or less.',
			},
            subject: {
				required: 'Please enter subject.',
			},
            message: {
				required: 'Please enter message.',
			}

		},
        submitHandler:submitHandlercontactus
	});
});

function submitHandlercontactus(form) {
	disableFormButton(form);
	showLoader();
	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponse,
        error: formResponseError
    });
}

function formResponse(responseText, statusText){
	var form = $('#formcontactus');

	hideLoader();
	enableFormButton(form);
	if(statusText == 'success') {
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
