

$(document).ready(function(){
    $('#setting_form').validate({
    	ignore:'.ignore',
		rules: {
			username: {
				required: true,
                minlength: 2,
				maxlength: 24,
				remote: {
                    url: "check/username",
                    type: "post"
             	}
			},

			email: {
				required: true,
				email: true,
				minlength: 10,
				maxlength: 40,
			},
			password: {
				required: true,
				minlength: 8,
				maxlength: 24
			},
			password_confirmation: {
				required: true,
				minlength: 8,
				maxlength: 24,
				equalTo : "#password"
			},

		},
		messages: {
			username: {
				required: 'Please enter nick name.',
				remote: 'Nick name is already in use.',
			},
			email: {
				required: 'Please enter email address.',
				email: 'Please enter a valid email address.',
				minlength: 'Please enter email at least 10 characters long.',
				maxlength: 'Please enter email at least 40 characters or less.',
			},
			password: {
                required: 'Please enter your password.',
                minlength: 'Please enter password at least 8 characters long.',
                maxlength: 'Please enter password at least 24 characters or less.'
            },
            password_confirmation: {
                required: 'Please enter your confirm password.',
                minlength: 'Please enter password at least 8 characters long.',
                maxlength: 'Please enter password at least 24 characters or less.',
				equalTo : 'Password and the confirm password doesn\'t match.'
			}
		},
		submitHandler: submitHandlerSetting
	});
})

function submitHandlerSetting(form) {
	disableFormButton(form);
	showLoader();
	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseSetting,
        error: formResponseError
    });
}

function formResponseSetting(responseText, statusText){
	var form = $('#setting_form');
	hideLoader();
	enableFormButton(form);

	if(statusText == 'success') {
		if(responseText.type == 'success') {
			resetForm(form);
			// showSuccess(responseText.caption, null, function() {
				window.location.reload();
				// $('#signup-confirm-tab').trigger('click');
			// });
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


$("#password, #password_confirmation").keyup(function(){
    var password = $("#password").val();
    var confirmPassword = $("#password_confirmation").val();

    if(password !== "" && confirmPassword !== "") {
        $('#password_confirmation').valid();
        if (password == confirmPassword  && $('#password_confirmation').valid()) {
            $('#password_match').removeClass('d-none');
        }
        else {
            $('#password_match').addClass('d-none');
        }
    }

});
