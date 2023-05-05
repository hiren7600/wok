

$(document).ready(function() {

	$('#formreset').validate({
		rules: {
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
			}
		},
		messages: {
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
        submitHandler:submitHandlerreset
	});

	$("#password, #password_confirmation").keyup(function(){
    	var password = $("#password").val();
    	var confirmPassword = $("#password_confirmation").val();

    	if(password !== "" && confirmPassword !== "") {
    		$('#password_confirmation').valid();
    		if (password == confirmPassword && $('#password_confirmation').valid()) {
		        $('#password_match').removeClass('d-none');
		    }
		    else {
		    	$('#password_match').addClass('d-none');
		    }
    	}
	    
	});
});

function submitHandlerreset(form) {
	disableFormButton(form);
	showLoader();
	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponse,
        error: formResponseError
    });
}

function formResponse(responseText, statusText){
	var form = $('#formreset');

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
