

$(document).ready(function(){
    $('#formseo').validate({
    	ignore:'.ignore',
		rules: {
			page: {
				required: true,
			},
			meta_title: {
				required: true,
			},
			meta_keyword: {
				required: true,
			},
			meta_description: {
				required: true,
			},

		},
		messages: {
			page: {
				required: 'Please select name.'
			},
			meta_title: {
				required: 'Please enter meta title.'
			},
			meta_keyword: {
				required: 'Please enter meta keyword.'
			},
			meta_description: {
                required: 'Please enter meta description.'
            },
		},
		submitHandler: submitHandlerSeoSetting
	});

	$(document).on('change','#page, #state', function(e) {
		e.preventDefault();
		var page = $('#page').val();
		
		if(page != '') {
			if(page == 'location') {
		    	$('.state-box').removeClass('d-none');
		    }
		    else {
		    	$('.state-box').addClass('d-none');
		    	$('#state').val('');
		    }
		    var state = $('#state').val();
		    var formData = new FormData();
		    formData.append('page', page);
		    formData.append('state', state);

		    $this = $(this);
			$.ajax({
		        url:baseurl() + "/seo/page",
		        method:"POST",
		        data:formData,
		        contentType:false,
		        cache: true,
		        processData: false,

		        success:function(data){
		        	if(data.seo.meta_title != '') {
			            $('#meta_title').val(data.seo.meta_title);
		        	}
		        	else {
		        		$('#meta_title').val('');	
		        	}

		        	if(data.seo.meta_keyword != '') {
		            	$('#meta_keyword').val(data.seo.meta_keyword);
		        	}
		        	else {
		        		$('#meta_keyword').val('');	
		        	}

		        	if(data.seo.meta_description != '') {
		            	$('#meta_description').val(data.seo.meta_description);
		        	}
		        	else {
		        		$('#meta_description').val('');	
		        	}

		        	if(data.seo.meta_robot != '') {
		            	$('#meta_robot').val(data.seo.meta_robot);
		        	}
		        	else {
		        		$('#meta_robot').val('');	
		        	}
		        },

		    });

	    }
	    else {
	    	$('#page').val('');
			$('#state').val('');
	    }

	});
});

function submitHandlerSeoSetting(form) {
	disableFormButton(form);
	showLoader();
	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseSeoSetting,
        error: formResponseError
    });
}

function formResponseSeoSetting(responseText, statusText){
	var form = $('#formseo');
	hideLoader();
	enableFormButton(form);

	if(statusText == 'success') {
		if(responseText.type == 'success') {
			resetForm(form);
			// showSuccess(responseText.caption, null, function() {
				window.location.reload();
				// $('#signup-confirm-tab').trigger('click');
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
