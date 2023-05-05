$(document).ready(function(){

    jQuery.validator.setDefaults({
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group-input').append(error);
        },
    });


	jQuery.validator.addMethod('checkphoneno', function(value, element) {

		value = value.replace(/\ /g, '');
		value = value.replace(/\_/g, '');

		if(value.length < 10) {
			return false;
		}
		else {
			return true;
		}

	}, 'Please enter a valid phone no.');

	
	// $("#phoneno").inputmask();

	$.validator.addMethod("phone_exists", function(value, element) {
		var flag = true;
		$.ajax({
			url: 'check/phoneno', 
			data: { phoneno: value }, 
			method: 'post', 
			dataType: 'json', 
			cache: false,
			async: false,
			success:function(responseText, statusText){
			    if(statusText == 'success') {
					if(responseText.type == 'success') {
						flag = true;
					}
					else {
						flag = false;
					}
				}
				else {
					flag = false;
				}
			}
		});
	    return flag;
    });


    $.validator.addMethod("phone_valid", function(value, element) {
		var flag = true;
		$.ajax({
			url: 'valid/phoneno', 
			data: { phoneno: value }, 
			method: 'post', 
			dataType: 'json', 
			cache: false,
			async: false,
			success:function(responseText, statusText){
			    if(statusText == 'success') {
					if(responseText.type == 'success') {
						flag = true;
					}
					else {
						flag = false;
					}
				}
				else {
					flag = false;
				}
			}
		});
	    return flag;
    });

    $('#verify_form').validate({
    	ignore:'.ignore',
		rules: {
			phoneno: {
				required: true,
				phone_exists: true,
			},
			otp1: {
				required: true,
			},
			otp2: {
				required: true,
			},
			otp3: {
				required: true,
			},
			otp4: {
				required: true,
			},
		},
		messages: {
			phoneno: {
				required: 'Please enter phone number.',
				phone_exists: 'The number you\'re trying to use is already in use.',
				phone_valid: 'We’re sorry, but the number you\'re trying to use can\'t be used on WOK, please try again.',
				// maxlength: 'Phone number must be of 10 digits only.',
				// minlength: 'Phone number must be of 10 digits only.',
			},
			otp1: {
				required: 'Please enter otp number.',
			},
			otp2: {
				required: 'Please enter otp number.',
			},
			otp3: {
				required: 'Please enter otp number.',
			},
			otp4: {
				required: 'Please enter otp number.',
			},
		},
		submitHandler: submitHandlerVerify
	});


	addRemoveIgnore();

	$('#send-verification-btn').click(function(e){
		e.preventDefault();
		addRemoveIgnore();
		if($('#phoneno').valid()) {
			sendVerification();
		}
	});

	function sendVerification() {
		var formData = new FormData();

	    var phoneno = $('#phoneno').val();
	    var email = $('#email').val();

	    formData.append('phoneno', phoneno);
	    formData.append('email', email);

	    $.ajax({
	        url:baseurl() + "/send/verification/code",
	        method: "POST",
	        data: formData,
	        contentType: false,
	        cache: false,
	        processData: false,
	        success: function(data) {
	            if(data.type == 'success') {
	            	$('#signup-verification-tab').trigger('click');
	            	setTimeout(function(){
						addRemoveIgnore();
					},200);
	            }
	            else {
	            	showError(data.caption);
	            }
	        }
	    });
	}

	$('#code-verification-btn').click(function(e){
		e.preventDefault();
		$('#verify_form').submit();
	});


});


function addRemoveIgnore() {
	$('.tab-pane input').addClass('ignore');
	$('.tab-pane select').addClass('ignore');
	$('.tab-pane.active input').removeClass('ignore');
	$('.tab-pane.active select').removeClass('ignore');

	$([document.documentElement, document.body]).animate({
        scrollTop: $(".verify_form").offset().top
    }, 0);
}


function submitHandlerVerify(form) {
	disableFormButton(form);
	showLoader();

	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseVerify,
        error: formResponseError
    });
}

function formResponseVerify(responseText, statusText){
	var form = $('#verify_form');
	hideLoader();
	enableFormButton(form);
	
	if(statusText == 'success') {
		if(responseText.type == 'success') {
			resetForm(form);
			// showSuccess(responseText.caption, null, function() {
				window.location.href = responseText.redirectUrl;
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
