var formSelector = null;
$(document).ready(function(){
    $('#tags').select2({
        // minimumResultsForSearch: -1,
        tags: true,
        maximumSelectionLength: 5
    });

    $('#image_detail').validate({
    	ignore:'.ignore',
		rules: {
			image_caption: {
                required:true
			}
		},
		messages: {
			image_caption: {
                required :'Please add video caption.'
			}
		},
		submitHandler: submitHandlerimagedetail
	});

    $('#image_delete').validate({
		submitHandler: submitHandlerimagedelete
	});

	$('.edit-caption-open-btn').click(function() {
	    $(".edit-caption-box").attr("style", "display:block");
	});

	$('.media_comment_form').validate({
		ignore: [],
		rules: {
			media_comment: {
				required: true
			},
		},
		messages: {
			media_comment: {
				required: 'Please enter comment.'
			}
		},
        submitHandler:submitHandlerImageComment
	});

    $('#image_expose_form').validate({
		submitHandler: submitHandlerImageExpose
	});

    $('#tag_update_form').validate({
		submitHandler: submitHandlerImageTag
	});
    $('#image_show_form').validate({
		submitHandler: submitHandlerImageShow
	});
	$(document).on('click','.reply-comment-post-btn', function(e) {
		e.preventDefault();
		formSelector = $(this).parents('form');

		formSelector.validate({
			ignore: [],
			rules: {
				reply_comment: {
					required: true
				}
			},
			messages: {
				reply_comment: {
					required: 'Please enter comment.'
				},
			},
	        submitHandler:submitHandlerRplComment
		});

		formSelector.submit();
	});


	$(document).on('click','.remove-comment-link', function(e) {
		e.preventDefault();
		var media_comment_id = $(this).parents('.media-comment-item').data('media_comment_id');
		var media_id = $(this).parents('.media-comment-item').data('media_id');

	    var formData = new FormData();
	    formData.append('media_comment_id', media_comment_id);
	    formData.append('media_id', media_id);

	    $this = $(this);
		$.ajax({
	        url:baseurl() + "/media/delete/comment",
	        method:"POST",
	        data:formData,
	        contentType:false,
	        cache: true,
	        processData: false,

	        success:function(data){
	            if(data.type == 'success') {
	            	$('.comment'+data.media_comment_id).remove();
                    $(".comment-count span").text(data.media_comment);
	            }
	            else {
	                showError(data.caption);
	            }
	        },

	    });

	});

	$(document).on('click','.remove-rpl-comment-link', function(e) {
		e.preventDefault();
		var rpl_comment_id = $(this).parents('.feed-comment-item').data('rpl_comment_id');
		var media_id = $(this).parents('.media-comment-item').data('media_id');

	    var formData = new FormData();
	    formData.append('media_comment_id', rpl_comment_id);
	    formData.append('media_id', media_id);

	    $this = $(this);
		$.ajax({
	        url:baseurl() + "/media/delete/reply-comment",
	        method:"POST",
	        data:formData,
	        contentType:false,
	        cache: true,
	        processData: false,

	        success:function(data){
	            if(data.type == 'success') {
	            	$('.reply-comment'+data.media_comment_id).remove();
                    $(".comment-count span").text(data.media_comment);
	            }
	            else {
	                showError(data.caption);
	            }
	        },

	    });

	});

    $(document).on('click','.edit-caption-open-btn', function(e) {
	    $(".edit-caption-box").attr("style", "display:block");
	});

    $(document).on('click','.edit-tag-open-btn', function(e) {
        $(".tag-box-open").attr("style", "display:block");
	});
    $(document).on('click','.cancel-tags', function(e) {
        $(".tag-box-open").attr("style", "display:none");
	});
    $(document).on('click','.cancel-caption', function(e) {
        $(".edit-caption-box").attr("style", "display:none");
	});

	$(document).on('click','.post-rpl', function(e) {
		e.preventDefault();
		$(this).parents('.media-comment-item').find('.comment-reply-write').removeClass('d-none');
		$([document.documentElement, document.body]).animate({
	        scrollTop: $(this).parents('.media-comment-item').find('.comment-reply-write').offset().top - 100
	    }, 500);
	});

	$(document).on('click','.cancel-rply-comment-btn', function(e) {
		e.preventDefault();
		$(this).parents('.comment-reply-write').find('textarea').val('');
		$(this).parents('.comment-reply-write').addClass('d-none');
	});

	$(document).on('click','.media-comment-cancel-btn', function(e) {
		e.preventDefault();
		$(this).parents('form').find('textarea').val('');
	});

    $('.like-button').click(function(e) {
		e.preventDefault();
	    var media_id = $(this).data("media_id");

	    var formData = new FormData();
	    formData.append('media_id', media_id);
        $.ajax({
            url:baseurl() + "/media-like",
            method: "POST",
            data: formData,
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                // $(".like-button").toggleClass("active");

                if ($(".like-button").hasClass("active")) {
                    $(".like-button").removeClass("active");
                }else{
                    $(".like-button").addClass("active");
                }

                $(".like-button span").text(data.mediacounts);
                $(".comment-count span").text(data.media_comment);

            }
        });
	});

});
function submitHandlerImageShow(form) {
	disableFormButton(form);
	showLoader();

	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseImageShow,
        error: formResponseError
    });
}
function formResponseImageShow(responseText, statusText){
	var form = $('#image_show_form');
	hideLoader();
	enableFormButton(form);

	if(statusText == 'success') {
		if(responseText.type == 'success') {
			resetForm(form);
            window.location.reload();
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
function submitHandlerImageTag(form) {
	disableFormButton(form);
	showLoader();

	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseImageTag,
        error: formResponseError
    });
}
function formResponseImageTag(responseText, statusText){
	var form = $('#tag_update_form');
	hideLoader();
	enableFormButton(form);

	if(statusText == 'success') {
		if(responseText.type == 'success') {
			resetForm(form);
            window.location.reload();
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

function submitHandlerImageExpose(form) {
	disableFormButton(form);
	showLoader();

	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseImageExpose,
        error: formResponseError
    });
}
function formResponseImageExpose(responseText, statusText){
	var form = $('#image_expose_form');
	hideLoader();
	enableFormButton(form);

	if(statusText == 'success') {
		if(responseText.type == 'success') {
			resetForm(form);
            window.location.reload();
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

function submitHandlerRplComment(form) {
	disableFormButton(form);
	showLoader();
	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseRplComment,
        error: formResponseError
    });
}
function formResponseRplComment(responseText, statusText){
	var form = formSelector;

	hideLoader();
	enableFormButton(form);

	if(statusText == 'success') {
		if(responseText.type == 'success') {
			resetForm(form);
			form.parents('.all-comments-here').find('.media-rpl-wrap').append(responseText.comment);
			form.find('textarea').val('');
			form.parents('.feed-comment-wrapper').find('.log-msg-wrapper').html('');
			form.parents('.comment-reply-write').addClass('d-none');
            $(".comment-count span").text(responseText.media_comment);
		}
		else {
			showError(responseText.caption, '', form.parents('.feed-comment-wrapper').find('.log-msg-wrapper'));
			if(responseText.errorfields !== undefined) {
				highlightInvalidFields(form, responseText.errorfields);
			}
		}
	}
	else {
		showError('Unable to communicate with server.');
	}
}

function submitHandlerImageComment(form) {
	disableFormButton(form);
	showLoader();
	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseImageComment,
        error: formResponseError
    });
}
function formResponseImageComment(responseText, statusText){
	var form = $('.media_comment_form');

	hideLoader();
	enableFormButton(form);

	if(statusText == 'success') {
		if(responseText.type == 'success') {
			resetForm(form);
			$('.video-comments-list').append(responseText.comment);
			form.find('textarea').val('');
			form.parents('.feed-comment-wrapper').find('.log-msg-wrapper').html('');
            $(".comment-count span").text(responseText.media_comment);
		}
		else {
			showError(responseText.caption, '', form.parents('.feed-comment-wrapper').find('.log-msg-wrapper'));
			if(responseText.errorfields !== undefined) {
				highlightInvalidFields(form, responseText.errorfields);
			}
		}
	}
	else {
		showError('Unable to communicate with server.');
	}
}

function submitHandlerimagedetail(form) {
	disableFormButton(form);
	showLoader();

	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseimagedetail,
        error: formResponseError
    });
}
function formResponseimagedetail(responseText, statusText){
	var form = $('#image_detail');
	hideLoader();
	enableFormButton(form);

	if(statusText == 'success') {
		if(responseText.type == 'success') {
			resetForm(form);
            window.location.reload();
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

function submitHandlerimagedelete(form) {
	disableFormButton(form);
	showLoader();

	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseimagedelete,
        error: formResponseError
    });
}

function formResponseimagedelete(responseText, statusText){
	var form = $('#image_delete');
	hideLoader();
	enableFormButton(form);

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

