$(document).ready(function() {
    $('#notification_setting_form').validate({
		submitHandler: submitHandlerNotificationSetting
	});
});

function submitHandlerNotificationSetting(form) {
	disableFormButton(form);
	showLoader();
	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseNotificationSetting,
        error: formResponseError
    });
}
function formResponseNotificationSetting(responseText, statusText){
	var form = $('#notification_setting_form');
	hideLoader();
	enableFormButton(form);
    // alert(statusText == 'success');
	if(statusText == 'success') {
		if(responseText.type == 'success') {
			resetForm(form);
            refreshPage();
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

