$(document).ready(function() {
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
            'front/tinymce/content.css'
        ],
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

    $("#city").on('keyup', function() {
    	$('#select_from_list').val(0);
	});
    
    $.validator.addMethod('selectlist', function (value, element) {
	    if($('#select_from_list').val() == 0) {
	    	return false;
	    }
	    return true;
	});

    $('#about_form').validate({
    	ignore:'.ignore',
		rules: {
			username: {
				required: true,
                minlength: 2,
				maxlength: 24,
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
			'role[]': {
				required: true
			},
            'looking_for[]':{
                required: true
            },
            dateofbirth: {
				required: true,
				validDOB: true
			},
			city: {
				required: true,
				selectlist: true,
			},
		},
		messages: {
			username: {
				required: 'Please enter nick name.',
				remote: 'Nick name is already in use.',
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
			'role[]': {
				required: 'Please select role.'
			},
            'looking_for[]':{
                equired: 'Please select Looking for.'
            },
            dateofbirth: {
				required: 'Please select date of birth.'
			},
			city:{
                required: 'Please select city.',
                selectlist: 'Please select location from the list.'
            }
		},
		submitHandler: submitHandleraboutedit
	});
    $("#dateofbirth").datepicker({
        dateFormat: 'mm/dd/yy',
        minDate: new Date(1900, 1 - 1, 1),
        maxDate: '-18Y',
        // defaultDate: new Date(1970,1-1,1),
        changeMonth: true,
        changeYear: true,
        yearRange: '-110:-18'

    });

    // $('#btn-upload-about').click(function(e){
    //     e.preventDefault();
    //     if($('#about_form').valid()) {
    //         $('#about_form').submit();
    //         // $('#signup-upload-tab').trigger('click');
    //     }
    // });
});

function submitHandleraboutedit(form) {
	disableFormButton(form);
	showLoader();
	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseaboutedit,
        error: formResponseError
    });
}
function formResponseaboutedit(responseText, statusText){
	var form = $('#about_form');
	hideLoader();
	enableFormButton(form);
    // alert(statusText == 'success');
	if(statusText == 'success') {
		if(responseText.type == 'success') {
			resetForm(form);
				
                window.location.href = baseurl() + '/profile';
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

