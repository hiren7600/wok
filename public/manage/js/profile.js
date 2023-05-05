$(document).ready(function() {

	$('#formprofile').validate({
		rules: {
			firstname: {
				required: true
			},
			lastname: {
				required: true
			},
			email: {
				required: true,
				email: true
			},
			oldpassword: {
				required:function(a,b){
                    if($('#password_confirmation').val() != '' || $('#password').val() != ''){
                        return true;
                    }
                    else{
                        return false;
                    }
                }
			},
			password: {
				required:function(){
					if($('#password_confirmation').val() != '' || $('#oldpassword').val() != ''){
						return true;
					}
					else{
						return false;
					}
				}
			},
			password_confirmation: {
				required:function(a,b){
					if($('#password').val() != '' || $('#oldpassword').val() != ''){
						return true;
					}
					else{
						return false;
					}
				},
				equalTo:'#password'
			},
			imagefile: {
				extension: 'jpg,jpeg,png'
			}
		},
		messages: {
			firstname: {
				required: 'Please enter first name.'
			},
			lastname: {
				required: 'Please enter last name.'
			},
			email: {
				required: 'Please enter email address.',
				email: 'Please enter valid email address.'
			},
			oldpassword: {
				required: 'Please enter old password.'
			},
			password: {
				required: 'Please enter new password.'
			},
			password_confirmation: {
				required: 'Please enter confirm password.',
				equalTo: 'Password mismatch.'
			},
			imagefile: {
				extension: 'Please select jpg, jpeg or png image.'
			}
		}
	});

});

function formResponse(responseText, statusText) {
    var form = $('#formprofile');
    hideLoader();
    enableFormButton(form);
	if(statusText == 'success') {
		if(responseText.type == 'success') {
			showSuccess(responseText.caption, null, function() {
				window.location.href = responseText.redirectUrl;
			});
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

function removeProfilePic() {
	showModal();
	confirmDialoue("Delete", 'Are you sure to delete image?', function(e){
		if (e) {
			hideModal();
			$('#deleteimage').val(1);
			$('.imagethumb').addClass('deleted').attr('title', 'To be deleted');
		}
		else {
			hideModal();
		}
	});
}