$(document).ready(function(){

	$.validator.addMethod('filesize', function (value, element, param) {
	    return this.optional(element) || (element.files[0].size <= param * 1000000)
	}, 'File size must be less than {0} MB');

    $('#contactadpost_form').validate({
    	ignore: [],
		rules: {
			message: {
				required: function(element) {
					if($('input[name="imagefile"]')[0].files.length == 0) {
						return true;
					}
					else {
						return false;
					}
				},
			},
			imagefile: {
				extension: 'jpg,JPG,jpeg,JPEG,png,PNG',
				filesize: 10,
			}
		},
		messages: {
			message: {
				required: 'Please enter message.'
			},
			imagefile: {
				extension: 'Please select vaild image.'
			}
		},

		submitHandler: submitHandlerContactadpost
	});

    $('#delete_ad_form').validate({
        ignore:'.ignore',
		submitHandler: submitHandlerDeleteAccount
	});

	$('.delete-ad-btn').click(function(e) {
		e.preventDefault();
		//

		confirmDialoue("Delete", 'Are you sure you want to delete this account?', function(e){
			if (e) {
				$('#delete_ad_form').submit();
			}
			else {
				hideModal();
			}
		});

	});
	
});

function submitHandlerDeleteAccount(form) {
	disableFormButton(form);
	showLoader();
	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseDeleteAccount,
        error: formResponseError
    });
}

function formResponseDeleteAccount(responseText, statusText){
	var form = $('#delete_ad_form');
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

function submitHandlerContactadpost(form) {
	disableFormButton(form);
	showLoader();

	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseContactadpost,
        error: formResponseError
    });
}

function formResponseContactadpost(responseText, statusText){
	var form = $('#contactadpost_form');
	hideLoader();
	enableFormButton(form);

	if(statusText == 'success') {
		if(responseText.type == 'success') {
			resetForm(form);
			// showSuccess(responseText.caption, null, function() {
				$('.log-msg-wrapper').html('');

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
