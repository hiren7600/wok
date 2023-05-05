$(document).ready(function(){
    $('textarea#tiny').tinymce({
        'mode': 'textareas',
        menubar: false,
        width: 'auto',
        forced_root_block: 'div',
        mobile: {
            theme: 'silver',
            plugins: 'lists advlist autoresize',
            toolbar: [
                'bold italic underline | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent',
            ],
        },
        plugins: 'lists advlist autoresize paste',
        paste_auto_cleanup_on_paste: true,
        autoresize_bottom_margin: 0,
        min_height: 250,
        toolbar: [
            'fontselect fontsizeselect | forecolor backcolor | bold italic underline | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | undo redo',
        ],
        valid_elements: 'div,p[style],strong,em,span[style],ul,ol,li,br',
        valid_styles: {
            '*': 'font-size,font-family,color,background-color,text-decoration,text-align,padding-left,list-style-type'
        },
        powerpaste_word_import: 'clean',
        powerpaste_html_import: 'clean',
        content_css: [],
        statusbar: false,
        skin: 'oxide-dark',
        content_css: [
            '../front/tinymce/content.css'
        ],
    });

    $.validator.addMethod('filesize', function (value, element, param) {
	    return this.optional(element) || (element.files[0].size <= param * 1000000)
	}, 'File size must be less than {0} MB');

   $.validator.addMethod('maxfiles', function (value, element, param) {
		// console.log(element.files.length);
	    return this.optional(element) || (element.files.length <= param)
	}, 'You can upload maximum {0} files at time.');

    $('#creatediscussion_form').validate({
        ignore:'.ignore',
    	rules: {
			title: {
				required: true
			},
			desc: {
				required: true
			},
            imagefile: {
                // required:true,
				extension: 'jpg,jpeg,png',
				filesize:  10
			}
		},
		messages: {
            title: {
				required: 'Please enter title.',
			},
            desc: {
				required: 'Please enter description.',
			},
            imagefile: {
                // required :'Please select image.',
				extension: 'Please select jpg, jpeg or png  file.'
			}
		},
		submitHandler: submitHandlerCreateDiscussion
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


function submitHandlerCreateDiscussion(form) {
	disableFormButton(form);
	showLoader();
	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseCreateDiscussion,
        error: formResponseError
    });
}

function formResponseCreateDiscussion(responseText, statusText){
	var form = $('#creatediscussion_form');
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

