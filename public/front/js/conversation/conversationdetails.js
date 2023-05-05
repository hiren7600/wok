$(document).ready(function(){

    $.validator.addMethod('filesize', function (value, element, param) {
	    return this.optional(element) || (element.files[0].size <= param * 1000000)
	}, 'File size must be less than {0} MB');

    $('#conversation_details_form').validate({
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

		submitHandler: submitHandlerConversationDetails
	});
    readconversation();
});

function submitHandlerConversationDetails(form) {
	disableFormButton(form);
	showLoader();

	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseConversationDetails,
        error: formResponseError
    });
}

function formResponseConversationDetails(responseText, statusText){
	var form = $('#conversation_details_form');
	hideLoader();
	enableFormButton(form);

	if(statusText == 'success') {
		if(responseText.type == 'success') {
			resetForm(form);
            $('.all-message-list').append(responseText.comment);
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

function readconversation() {
    var formData = new FormData();
    var conversation_id = $('input[name=conversation_id]').val();
    formData.append('conversation_id', conversation_id);
    $.ajax({
        url:baseurl() + "/conversation-mark-read",
        method: "POST",
        data: formData,
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
            setTimeout(function() {
                $(".new-msg-tag").css("display", "none")
            }, 5000);
        }
    });
};




