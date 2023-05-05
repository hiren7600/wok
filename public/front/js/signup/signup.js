$(document).ready(function(){
	$('#gender').select2({
      	minimumResultsForSearch: -1
    });
    $('#sexual_orientation').select2({
      	minimumResultsForSearch: -1
    });
    $('#relationship_status').select2({
      	minimumResultsForSearch: -1
    });
    $('#role').select2({
      	minimumResultsForSearch: -1
    });

    $("#city").on('keyup', function() {
    	$('#select_from_list').val(0);
	});

    $( "#dateofbirth" ).datepicker({
		dateFormat: 'mm/dd/yy',
		minDate: new Date(1900,1-1,1), maxDate: '-18Y',
		// defaultDate: new Date(1970,1-1,1),
		changeMonth: true,
		changeYear: true,
		yearRange: '-110:-18'

    });

    jQuery.validator.setDefaults({
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group-input').append(error);
        },
    });

    jQuery.validator.addMethod(
        "validDOB",
        function(value, element) {              
            var from = value.split("/"); // MM DD YYYY

            var month = from[0];
            var day = from[1];
            var year = from[2];
            var age = 18;

            var mydate = new Date();
            mydate.setFullYear(year, month-1, day);

            var currdate = new Date();
            var setDate = new Date();

            setDate.setFullYear(mydate.getFullYear() + age, month-1, day);

            if ((currdate - setDate) >= 0){
                return true;
            }else{
                return false;
            }
        },
        "Sorry, you must be 18 years of age to apply"
    );

    $.validator.addMethod('filesize', function (value, element, param) {
	    return this.optional(element) || (element.files[0].size <= param * 1000000)
	}, 'File size must be less than {0} MB');

	$.validator.addMethod('selectlist', function (value, element) {
	    if($('#select_from_list').val() == 0) {
	    	return false;
	    }
	    return true;
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

    $('#signup_form').validate({
    	ignore:'.ignore',
		rules: {
			username: {
				required: true,
                minlength: 2,
				maxlength: 24,
				remote: {
                    url: "check/username",
                    type: "post",
                    complete: function (data) {
		                if(data) {
		                	if(data.responseText == "true") {
		                		$('.username-input-box').append("<span class='invalid-feedback text-success user-available d-inline-block'>Nick name is available.</span>");
		                	}
		                	else {
		                		$('.user-available').remove();
		                	}

		                }
		            }
             	}
			},
			dateofbirth: {
				required: true,
				validDOB: true
			},
			gender: {
				required: true
			},
			sexual_orientation: {
				required: true
			},
			relationship_status: {
				required: true
			},
			role: {
				required: true
			},
			city: {
				required: true,
				selectlist: true,
			},
			email: {
				required: true,
				email: true,
				minlength: 10,
				maxlength: 40,
				remote: {
                    url: "check/email",
                    type: "post"
             	}
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
			imagefile: {
				extension: 'jpg,jpeg,png,gif',
				filesize:  10
			},
			phoneno: {
				required: true,
				phone_exists: true,
				// phone_valid: true,

				// remote: {
    //                 url: "check/phoneno",
    //             	type: "post",
    //          	}
				// minlength: 10,
				// maxlength: 10,
				// checkphoneno: true
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
			username: {
				required: 'Please enter nick name.',
				remote: 'Nick name is already in use.',
			},
			dateofbirth: {
				required: 'Please select date of birth.'
			},
			gender: {
				required: 'Please select gender.'
			},
			sexual_orientation: {
				required: 'Please select sexual orientation.'
			},
			relationship_status: {
				required: 'Please select relationship status.'
			},
			role: {
				required: 'Please select role.'
			},
			city: {
				required: 'Please select location.',
				selectlist: 'Please select location from the list.'
			},
			email: {
				required: 'Please enter email address.',
				email: 'Please enter a valid email address.',
				remote: 'Email address is already in use.',
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
			},
			imagefile: {
				extension: 'Please select jpg, jpeg, png or gif file.'
			},
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
		submitHandler: submitHandlerSignup
	});

	//setup before functions
	var usernameTypingTimer;
	var usernameDoneTypingInterval = 0;
	//on keyup, start the countdown
	$('#username').keyup(function(){
	    clearTimeout(usernameTypingTimer);
	    if ($('#username').val()) {
	        usernameTypingTimer = setTimeout(usernameDoneTyping, usernameDoneTypingInterval);
	    }
	});

	//setup before functions
	var emailTypingTimer;
	var emailDoneTypingInterval = 0;
	//on keyup, start the countdown
	$('#email').keyup(function(){
	    clearTimeout(emailTypingTimer);
	    if ($('#email').val()) {
	        emailTypingTimer = setTimeout(emailDoneTyping, emailDoneTypingInterval);
	    }
	});

	addRemoveIgnore();

	$('#btn-input-signup').click(function(e){
		e.preventDefault();
		if($('#signup_form').valid()) {
			$('#signup-phone-tab').trigger('click');
			setTimeout(function(){
				addRemoveIgnore();
			},200);
		}
	});

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
		if($('#signup_form').valid()) {
			completeVerification();
		}
	});

	function completeVerification() {
		var formData = new FormData();

	    var phoneno = $('#phoneno').val();
	    var email = $('#email').val();
	    var otp1 = $('#otp1').val();
	    var otp2 = $('#otp2').val();
	    var otp3 = $('#otp3').val();
	    var otp4 = $('#otp4').val();
	    var otp = otp1+otp2+otp3+otp4;

	    formData.append('phoneno', phoneno);
	    formData.append('email', email);
	    formData.append('otp', otp);

	    $.ajax({
	        url:baseurl() + "/complete/verification/code",
	        method: "POST",
	        data: formData,
	        contentType: false,
	        cache: false,
	        processData: false,
	        success: function(data) {
	            if(data.type == 'success') {
	            	$('#signup-upload-tab').trigger('click');
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

	$('#btn-upload-signup').click(function(e){
		e.preventDefault();
		if($('#signup_form').valid()) {
			$('#signup_form').submit();
			// $('#signup-upload-tab').trigger('click');
		}
	});

	$('.uploading-area').on('dragover', function(){
        $(this).addClass('file_drag_over');
        return false;
    });

    $('.uploading-area').on('dragleave', function(){
        $(this).removeClass('file_drag_over');
        return false;
    });

    //upload images
    $('.uploading-area').on('drop', function(e){
        e.preventDefault();

        
            $(this).removeClass('file_drag_over');
            var files_list = e.originalEvent.dataTransfer.files;

            if(files_list.length > 0){
                // dd(e.originalEvent.dataTransfer.files);
                document.querySelector('#imagefile').files = e.originalEvent.dataTransfer.files;
                
                var valid = $('#signup_form').valid();
                
		        if(valid){
		            $this = document.querySelector('#imagefile');
		            showImage($this);
		        }

            }
            if(files_list.length == 0){
                $('#imagefile').val('');
            }
        
    });

	$('#imagefile').change(function(e) {
        e.preventDefault();
        var files_list = $(this).get(0).files
        
        var valid = $('#signup_form').valid();
        if(valid){
            $this = this;
            showImage($this);
        }

    });

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

	$('#resend-verification').click(function(){
		userid = $('#user_id').val();
		ajaxUpdate(baseurl() + '/resend/verification', { user_id: userid }, function(responseText, statusText) {
			hideLoader();
			if(statusText == 'success') {
				if(responseText.type == 'success') {
					showSuccess(responseText.caption);
			    }
			    else {
			        showError(responseText.caption);
			    }
			}
			else {
				showError('Unable to communicate with server.');
			}
		});
	});

});

function showImage($this){
    if ($this.files && $this.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
    		var displayimage = e.target.result;
	    	$('.uploading-img').attr('src',displayimage);
	    	$('.btn-upload-photo span').text('Select photo to re-upload');
        }
        reader.readAsDataURL($this.files[0]);
    }
}

function addRemoveIgnore() {
	$('.tab-pane input').addClass('ignore');
	$('.tab-pane select').addClass('ignore');
	$('.tab-pane.active input').removeClass('ignore');
	$('.tab-pane.active select').removeClass('ignore');

	$([document.documentElement, document.body]).animate({
        scrollTop: $(".signup_form").offset().top
    }, 0);
}


function usernameDoneTyping () {
	if($('#username').val().length > 2) {
	    $('#username').valid();
	    usernameDoneTypingInterval = 1000;
	}
}

function emailDoneTyping () {
	if($('#email').val().length > 2) {
	    $('#email').valid();
	    emailDoneTypingInterval = 1000;
	}
}


function submitHandlerSignup(form) {
	disableFormButton(form);
	showLoader();

	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseSignup,
        error: formResponseError
    });
}

function formResponseSignup(responseText, statusText){
	var form = $('#signup_form');
	hideLoader();
	enableFormButton(form);
	
	if(statusText == 'success') {
		if(responseText.type == 'success') {
			resetForm(form);
			// showSuccess(responseText.caption, null, function() {
				// window.location.href = responseText.redirectUrl;
				$('.log-msg-wrapper').html('');
				$('#user_id').val(responseText.user_id);
				$('.mailto-user').attr('href', 'mailto:'+responseText.user_email);
				$('.mailto-user').text(responseText.user_email);
				$('#signup-confirm-tab').trigger('click');
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
