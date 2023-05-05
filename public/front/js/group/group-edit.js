$(document).ready(function(){


    $('#editgroup_form').validate({
    	rules: {
			title: {
				required: true
			},
			desc: {
				required: true
			}
		},
		messages: {
            title: {
				required: 'Please enter group title.',
			},
            desc: {
				required: 'Please enter description.',
			}

		},
		submitHandler: submitHandlerCreateGroup
	});

});


function submitHandlerCreateGroup(form) {
	disableFormButton(form);
	showLoader();
	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseCreateGroup,
        error: formResponseError
    });
}

function formResponseCreateGroup(responseText, statusText){
	var form = $('#editgroup_form');
	hideLoader();
	enableFormButton(form);

	if(statusText == 'success') {
		if(responseText.type == 'success') {
			resetForm(form);
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

