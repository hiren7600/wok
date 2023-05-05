$(document).ready(function(){

	$([document.documentElement, document.body]).animate({
        scrollTop: 0
    }, 0);

    $('#tags').select2({
        // minimumResultsForSearch: -1,
        tags: true,
        maximumSelectionLength: 5
    });

    $.validator.addMethod('filesize', function (value, element, param) {
	    return this.optional(element) || (element.files[0].size <= param * 1000000)
	}, 'File size must be less than {0} MB');

    $('#uploadimage_form').validate({
    	ignore:'.ignore',
		rules: {
			imagefile: {
                required:true,
				extension: 'jpg,jpeg,png,gif',
				filesize:  10
			},
            tnc: {
				required: true
			}
		},
		messages: {
			imagefile: {
                required :'Please select image.',
				extension: 'Please select jpg, jpeg, png or gif file.'
			},
            tnc:{
                required: 'Please select terms and condition.'
            }
		},
		submitHandler: submitHandlerImageUpload
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
        var files_list = $(this).get(0).files

        var valid = $('#imagefile').valid();

        if(valid){
            $this = this;
            showImage($this);
        }
        else {
            $('.uploading-img').attr('src',$('.uploading-img').data('src'));
        }

    });

    function showImage($this){
        console.log($this.files);
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

});
function submitHandlerImageUpload(form) {
	disableFormButton(form);
	// showLoader();
    $([document.documentElement, document.body]).animate({
        scrollTop: 125
    }, 0);
	$(form).ajaxSubmit({
		dataType: 'json',
		xhr: formResponseXhr,
        success: formResponseImageUpload,
        error: formResponseError
    });
}

function formResponseXhr(){
	var xhr = new window.XMLHttpRequest();
    xhr.upload.addEventListener("progress", function(evt) {
        if (evt.lengthComputable) {
            var percentComplete = Math.ceil(evt.loaded / evt.total * 100);
            //Do something with upload progress here
            // var percentVal = parseInt(percentComplete);
            var percentVal = percentComplete;
            $('.progress-wrapper').addClass('active');
            $('.progress-wrapper .file-progress').attr('data-progresstext', percentVal+'%');
            $('.progress-wrapper .file-progress .progress__bar').css('width', percentVal+'%');
            if(percentVal == 100) {
                $('.progress-wrapper .file-progress').attr('data-progresstext', 'Processing data..');
            }
        }
   }, false);
   return xhr;
}

function formResponseImageUpload(responseText, statusText){
	var form = $('#uploadimage_form');
	// hideLoader();
	enableFormButton(form);

	if(statusText == 'success') {
		if(responseText.type == 'success') {
			resetForm(form);
            window.location.reload();
			// showSuccess(responseText.caption, null, function() {
				// window.location.href = responseText.redirectUrl;
				// $('.log-msg-wrapper').html('');
				// $('#user_id').val(responseText.user_id);
				// $('.mailto-user').attr('href', 'mailto:'+responseText.user_email);
				// $('.mailto-user').text(responseText.user_email);
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
