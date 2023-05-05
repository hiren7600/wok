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
    $('#edit_discussion_form').validate({
    	rules: {
			title: {
				required: true
			},
			desc: {
				required: true
			}
		},
		messages: {
            title: {
				required: 'Please enter group title.',
			},
            desc: {
				required: 'Please enter description.',
			}

		},
		submitHandler: submitHandlerEditDiscussion
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


function submitHandlerEditDiscussion(form) {
	disableFormButton(form);
	showLoader();
	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseEditDiscussion,
        error: formResponseError
    });
}

function formResponseEditDiscussion(responseText, statusText){
	var form = $('#edit_discussion_form');
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

