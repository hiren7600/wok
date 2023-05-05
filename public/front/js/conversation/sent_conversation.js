$(document).ready(function(){
    $('#conversation_delete_form').validate({
		submitHandler: submitHandlerConversationDelete
	});
});

function submitHandlerConversationDelete(form) {
	disableFormButton(form);
	showLoader();

	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseConversationDelete,
        error: formResponseError
    });
}

function formResponseConversationDelete(responseText, statusText){

	var form = $('#conversation_delete_form');
	hideLoader();
	enableFormButton(form);

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

