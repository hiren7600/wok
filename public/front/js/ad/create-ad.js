$(document).ready(function(){

	$.validator.addMethod('selectlist', function (value, element) {
	    if($('#select_from_list').val() == 0) {
	    	return false;
	    }
	    return true;
	});

	$.validator.addMethod('filesize', function (value, element, param) {
	    return this.optional(element) || (element.files[0].size <= param * 1000000)
	}, 'File size must be less than {0} MB');

	$.validator.addMethod('maxfiles', function (value, element, param) {
		// console.log(element.files.length);
	    return this.optional(element) || (element.files.length <= param)
	}, 'You can upload maximum {0} files at time.');

	$("#location").on('keyup', function() {
    	$('#select_from_list').val(0);
	});

    $('#create_ad_form').validate({
    	ignore:'.ignore',
		rules: {
			title: {
				required: true
			},
			content: {
				required: true
			},
			location: {
				required: true,
				selectlist: true,
			},
			"imagefile[]": {
				extension: 'jpg,jpeg,png,gif',
				filesize:  10, 
				maxfiles:  4, 

			},
			tnc: {
				required: true
			},
		},
		messages: {
			title: {
				required: 'Please enter title.'
			},
			content: {
				required: 'Please enter content.'
			},
			location: {
				required: 'Please select location.',
				selectlist: 'Please select location from the list.'
			},
			"imagefile[]": {
				extension: 'Please select jpg, jpeg, png or gif file.'
			},
			tnc: {
				required: 'Please select terms and condition.'
			},
		},
		submitHandler: submitHandlerad
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
        $('.uploading-multiple-img').remove();
        
            $(this).removeClass('file_drag_over');
            var files_list = e.originalEvent.dataTransfer.files;

            if(files_list.length > 0){
                // dd(e.originalEvent.dataTransfer.files);
                document.querySelector('#imagefile').files = e.originalEvent.dataTransfer.files;
                
                var valid = $('#imagefile').valid();
                
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
        $('.uploading-multiple-img').remove();
        var files_list = $(this).get(0).files
        
        var valid = $('#imagefile').valid();
        if(valid){
            $this = this;
            showImage($this);
        }

    });
});

function showImage($this){
	$('.uploading-multiple-img').remove();
    if ($this.files) {
    	jQuery.each($this.files, function(index, file) {
			var reader = new FileReader();
	        reader.onload = function (e) {
	    		var displayimage = e.target.result;
		    	// $('.uploading-img').attr('src',displayimage);
		    	$('.uploading-img').hide();
		    	img = '<img class="uploading-multiple-img" src="' + displayimage +'">';
		    	$('.uploading-area').prepend(img);
	        }
	        reader.readAsDataURL(file);    
		});
    	$('.btn-upload-photo span').text('Select photo to re-upload');
        
    }
}


function submitHandlerad(form) {
	disableFormButton(form);
	showLoader();

	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponsead,
        error: formResponseError
    });
}

function formResponsead(responseText, statusText){
	var form = $('#create_ad_form');
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
