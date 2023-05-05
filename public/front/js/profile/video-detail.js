var formSelector = null;
$(document).ready(function(){
    $('#kink-video-play').trigger('play');
    $('#tags').select2({
        // minimumResultsForSearch: -1,
        tags: true,
        maximumSelectionLength: 5
    });

    $('#video_detail').validate({
    	ignore:'.ignore',
		rules: {
			video_caption: {
                required:true
			}
		},
		messages: {
			video_caption: {
                required :'Please add video caption.'
			}
		},
		submitHandler: submitHandlerVideoDetail
	});

    $('#video_delete').validate({
        submitHandler: submitHandlerVideoDelete
    });

    $('#video_expose_form').validate({
        submitHandler: submitHandlerVideoExpose
    });

    $('#video_tag_update_form').validate({
		submitHandler: submitHandlerVideoTag
	});

    $('#video_show_form').validate({
		submitHandler: submitHandlerVideoShow
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
                    $(".video-comment"+media_id).text(data.media_comment);
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
                    $(".video-comment"+media_id).text(data.media_comment);
	            }
	            else {
	                showError(data.caption);
	            }
	        },

	    });

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
                if ($(".like-button").hasClass("active")) {
                    $(".like-button").removeClass("active");
                }else{
                    $(".like-button").addClass("active");
                }

                $(".video-like"+media_id).text(data.mediacounts);
                $(".like-button span").text(data.mediacounts);
            }
        });
	});

});
function submitHandlerVideoShow(form) {
	disableFormButton(form);
	showLoader();

	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseVideoShow,
        error: formResponseError
    });
}
function formResponseVideoShow(responseText, statusText){
	var form = $('#video_show_form');
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

function submitHandlerVideoTag(form) {
	disableFormButton(form);
	showLoader();

	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseVideoTag,
        error: formResponseError
    });
}
function formResponseVideoTag(responseText, statusText){
	var form = $('#video_tag_update_form');
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
            $(".video-comment"+responseText.media_id).text(responseText.media_comment);
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
            $(".video-comment"+responseText.media_id).text(responseText.media_comment);
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

function submitHandlerVideoDetail(form) {
	disableFormButton(form);
	showLoader();

	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseVideoDetail,
        error: formResponseError
    });
}

function formResponseVideoDetail(responseText, statusText){
	var form = $('#video_detail');
	hideLoader();
	enableFormButton(form);

	if(statusText == 'success') {
		if(responseText.type == 'success') {
			resetForm(form);
            refreshPage();
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

function submitHandlerVideoExpose(form) {
	disableFormButton(form);
	showLoader();

	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseVideoExpose,
        error: formResponseError
    });
}

function formResponseVideoExpose(responseText, statusText){
	var form = $('#video_expose_form');
	hideLoader();
	enableFormButton(form);

	if(statusText == 'success') {
		if(responseText.type == 'success') {
			resetForm(form);
            refreshPage();
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

function submitHandlerVideoDelete(form) {
	disableFormButton(form);
	showLoader();

	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseVideoDelete,
        error: formResponseError
    });
}

function formResponseVideoDelete(responseText, statusText){
	var form = $('#video_delete');
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
