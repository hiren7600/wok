$(document).ready(function(){
    $.validator.addMethod('filesize', function (value, element, param) {
	    return this.optional(element) || (element.files[0].size <= param * 1000000)
	}, 'File size must be less than {0} MB');

    $('#chnage_profile').validate({
    	ignore:'.ignore',
        keypress : true,
		rules: {
			imagefile: {
                required:true,
				extension: 'jpg,JPG,jpeg,JPEG,png,PNG',
				filesize:  10
			}
		},
		messages: {
			imagefile: {
                required :'Please select image.',
				extension: 'Please select jpg, jpeg, png  file.'
			}
		},
		submitHandler: submitHandlerProfile
	});

    $('#conversation_form').validate({
        ignore:'.ignore',
		rules: {
			subject: {
                required:true
			},
            message: {
                required:true
			}
		},
		messages: {
			subject: {
                required :'Please select subject.'
			},
            message: {
                required :'Please select message.'
			}
		},

		submitHandler: submitHandlerConversation
	});


	$('#delete_account').validate({
        ignore:'.ignore',
		submitHandler: submitHandlerDeleteAccount
	});
	$('#block_account_form').validate({
        ignore:'.ignore',
		submitHandler: submitHandlerBlockAccount
	});

	$('.delete-account').click(function(e) {
		e.preventDefault();
		//

		confirmDialoue("Delete", 'Are you sure you want to delete this account?', function(e){
			if (e) {
				$('#delete_account').submit();
			}
			else {
				hideModal();
			}
		});

	});


    $('.block-user').click(function(e) {
		e.preventDefault();

        if ($(this).hasClass('unblockd')) {
            $('#block_account_form').submit();
        }
        else {
            confirmDialoue("Block", 'Are you sure you want to block this account?', function(e){
                if (e) {
                    $('#block_account_form').submit();
                }
                else {
                    hideModal();
                }
            });
        }
	});


	$('.friendship-btn-item').click(function(e) {
		e.preventDefault();
		status = $(this).data('status');
		console.log(status);
		if(status == 'friend-none') {
			$('#friendRequestModal').modal('show');
		}
		else if(status == 'friend-pending') {
			$('#friend_cancel_form').submit();
		}
		else if(status == 'friend-remove') {
			$('#friend_remove_form').submit();
		}
		else if(status == 'friend-request') {
			$('#friend_decline_form').submit();
		}
	});

	$('.friend-accept-btn').click(function(e) {
		e.preventDefault();
		$('#friend_accept_form').submit();
	});

	$('#friendrequest_form').validate({
		submitHandler: submitHandlerFriendRequest
	});

	$('#friend_cancel_form').validate({
		submitHandler: submitHandlerFriendRequestCancel
	});

	$('#friend_remove_form').validate({
		submitHandler: submitHandlerFriendRemove
	});

	$('#friend_decline_form').validate({
		submitHandler: submitHandlerFriendDecline
	});

	$('#friend_accept_form').validate({
		submitHandler: submitHandlerFriendAccept
	});

	$('.follow-btn-item').click(function(e) {
		e.preventDefault();

		status = $(this).data('status');
		console.log(status);
		if(status == 'follow') {
			$('#follow_form').submit();
		}
		else if(status == 'unfollow') {
			$('#unfollow_form').submit();
		}
	});

	$('#follow_form').validate({
		submitHandler: submitHandlerFollow
	});

	$('#unfollow_form').validate({
		submitHandler: submitHandlerUnfollow
	});

});

function submitHandlerFollow(form) {
	disableFormButton(form);
	showLoader();
	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseFollow,
        error: formResponseError
    });
}

function formResponseFollow(responseText, statusText){
	var form = $('#follow_form');
	hideLoader();
	enableFormButton(form);

	if(statusText == 'success') {
		if(responseText.type == 'success') {
            $('.follow-btn-item').data('status', 'unfollow');
            $('.follow-btn-item').text('Unfollow');
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

function submitHandlerUnfollow(form) {
	disableFormButton(form);
	showLoader();
	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseUnfollow,
        error: formResponseError
    });
}

function formResponseUnfollow(responseText, statusText){
	var form = $('#unfollow_form');
	hideLoader();
	enableFormButton(form);

	if(statusText == 'success') {
		if(responseText.type == 'success') {
			$('.follow-btn-item').data('status', 'follow');
            $('.follow-btn-item').text('Follow');
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

function submitHandlerFriendRequest(form) {
	disableFormButton(form);
	showLoader();
	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseFriendRequest,
        error: formResponseError
    });
}

function formResponseFriendRequest(responseText, statusText){
	var form = $('#friendrequest_form');
	hideLoader();
	enableFormButton(form);

	if(statusText == 'success') {
		if(responseText.type == 'success') {
			resetForm(form);
			$('#friendRequestModal').modal('hide');
            $('.friendship-btn-item').data('status', 'friend-pending');
            $('.friendship-btn-item').text('Cancel Friendship Request');
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

function submitHandlerFriendRequestCancel(form) {
	disableFormButton(form);
	showLoader();
	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseFriendRequestCancel,
        error: formResponseError
    });
}

function formResponseFriendRequestCancel(responseText, statusText){
	var form = $('#friend_cancel_form');
	hideLoader();
	enableFormButton(form);

	if(statusText == 'success') {
		if(responseText.type == 'success') {
			resetForm(form);
            $('.friendship-btn-item').data('status', 'friend-none');
            $('.friendship-btn-item').text('Request Friendship');
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

function submitHandlerFriendRemove(form) {
	disableFormButton(form);
	showLoader();
	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseFriendRemove,
        error: formResponseError
    });
}

function formResponseFriendRemove(responseText, statusText){
	var form = $('#friend_remove_form');
	hideLoader();
	enableFormButton(form);

	if(statusText == 'success') {
		if(responseText.type == 'success') {
			resetForm(form);
            $('.friendship-btn-item').data('status', 'friend-none');
            $('.friendship-btn-item').text('Request Friendship');
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

function submitHandlerFriendDecline(form) {
	disableFormButton(form);
	showLoader();
	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseFriendDecline,
        error: formResponseError
    });
}

function formResponseFriendDecline(responseText, statusText){
	var form = $('#friend_decline_form');
	hideLoader();
	enableFormButton(form);

	if(statusText == 'success') {
		if(responseText.type == 'success') {
			resetForm(form);
            $('.friendship-btn-item').data('status', 'friend-none');
            $('.friendship-btn-item').text('Request Friendship');
            $('.friend-accept-btn').remove();
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

function submitHandlerFriendAccept(form) {
	disableFormButton(form);
	showLoader();
	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseFriendAccept,
        error: formResponseError
    });
}

function formResponseFriendAccept(responseText, statusText){
	var form = $('#friend_accept_form');
	hideLoader();
	enableFormButton(form);

	if(statusText == 'success') {
		if(responseText.type == 'success') {
			resetForm(form);
            $('.friendship-btn-item').remove();
            $('.friend-accept-btn').remove();
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
	var form = $('#delete_account');
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

function submitHandlerBlockAccount(form) {
	disableFormButton(form);
	showLoader();
	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseBlockAccount,
        error: formResponseError
    });
}

function formResponseBlockAccount(responseText, statusText){
	var form = $('#block_account_form');
	hideLoader();
	enableFormButton(form);

	if(statusText == 'success') {
		if(responseText.type == 'success') {
			resetForm(form);
            window.location.reload();
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

function submitHandlerProfile(form) {
	disableFormButton(form);
	showLoader();
	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseProfile,
        error: formResponseError
    });
}

function formResponseProfile(responseText, statusText){
	var form = $('#chnage_profile');
	hideLoader();
	enableFormButton(form);

	if(statusText == 'success') {
		if(responseText.type == 'success') {
			resetForm(form);
            window.location.reload();
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

function submitHandlerConversation(form) {
	disableFormButton(form);
	showLoader();
	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseConversation,
        error: formResponseError
    });
}

function formResponseConversation(responseText, statusText){
	var form = $('#conversation_form');
	hideLoader();
	enableFormButton(form);

	if(statusText == 'success') {
		if(responseText.type == 'success') {
			resetForm(form);
            window.location.reload();
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

$('#imagefile').change(function(e) {
    $('#chnage_profile').submit();

    // var formData = new FormData();
    // var image = $(this).get(0).files[0];
    // formData.append('image', image);
    // if($("#chnage_profile").valid()) {
    //     $.ajax({
    //         url:baseurl() + "/profile",
    //         method: "POST",
    //         data: formData,
    //         dataType: 'JSON',
    //         contentType: false,
    //         cache: false,
    //         processData: false,
    //         success: function(data) {
    //             window.location.reload();
    //             // $('.profile-image').attr('src', data.image);
    //         }
    //     });
    // }
});
