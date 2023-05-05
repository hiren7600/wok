var userData = {};
$(document).ready(function() {
	$('#formuser').validate({
		disabled: true,
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
			phoneno: {
				required: true,
				number: true
			},
			designation_id: {
				required: true
			},
			password: {
				required:function(){
                    if($('#user_id').val() == '') {
                        return true;
                    }
                    else {
                        return false;
                    }
                }
			},
			password_confirmation: {
				required:function(){
                    if($('#user_id').val() == '') {
                        return true;
                    }
                    else {
                        return false;
                    }
                },
				equalTo : "#password"
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
				email: 'Please enter a valid email address.'
			},
			phoneno: {
				required: 'Please enter phone no.',
				number: 'Please enter valid mobile no.'
			},
			designation_id: {
				required: 'Please select designation.'
			},
			password: {
				required: 'Please enter password.'
			},
			password_confirmation: {
				required: 'Please enter confirm password.',
				equalTo: 'Password mismatch.'
			},
			imagefile: {
				extension: 'Please select jpg, jpeg or png file.'
			}
		}
	});

});


function formResponse(responseText, statusText) {
    var form = $('#formuser');
    hideLoader();
    enableFormButton(form);
	if(statusText == 'success') {
		if(responseText.type == 'success') {
			showSuccess(responseText.caption, null, function() {
				window.location.href = responseText.redirectUrl;
			});
		}
		else {
			showError(responseText.caption, responseText.errormessage);
			if(responseText.errorfields !== undefined) {
				highlightInvalidFields(form, responseText.errorfields);
			}
		}
	}
    else {
		showError('Unable to communicate with server.');
	}
}



function removeUserPic() {
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