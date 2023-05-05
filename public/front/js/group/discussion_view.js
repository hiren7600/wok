var formSelector = null;

$(document).ready(function(){

    $('#discussion_comment_form').validate({
        ignore: [],
		rules: {
			discussion_comment: {
				required: true
			},
		},
		messages: {
			discussion_comment: {
				required: 'Please enter comment.'
			}
		},
        submitHandler:submitHandlerDiscussionComment
	});
    $('#delete_discussion_form').validate({
		submitHandler: submitHandlerDeleteDiscussion
	});

    $('delete-discussion-btn').click(function(e){
		e.preventDefault();

		confirmDialoue("Delete", 'Are you sure you want to delete this discussion?', function(e){
			if (e) {
				$('#delete_discussion_form').submit();
			}
			else {
				hideModal();
			}
		});
	});

    $(document).on('click','#repl-comment-post-btn', function(e) {
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

    $('.btn-join-group').click(function(){
		$('#joingroup_form').submit();
	});

    $('#joingroup_form').validate({
		submitHandler: submitHandlerJoinGroup
	});

    $('.like-button').click(function(e) {
        e.preventDefault();
        var discussion_id = $(this).data("discussion_id");
        var formData = new FormData();
        formData.append('discussion_id', discussion_id);
        $.ajax({
            url:baseurl() + "/discussion/like",
            method: "POST",
            data: formData,
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {

                if ($(".like-button").hasClass("has-like")) {
                    $(".like-button").removeClass("has-like");
                }else{
                    $(".like-button").addClass("has-like");
                }
                $(".like-button span").text(data.DiscussionLikecounts);

            }
        });
    });

    $('.close-topic').click(function(e) {
        e.preventDefault();
        var discussion_id = $(this).data("discussion_id");
        var is_closed = $(this).data("is_closed");

        var formData = new FormData();
        formData.append('discussion_id', discussion_id);
        formData.append('is_closed', is_closed);
        $.ajax({
            url:baseurl() + "/discussion/close",
            method: "POST",
            data: formData,
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                refreshPage();
            }
        });
    });
});

function submitHandlerDiscussionComment(form) {
	disableFormButton(form);
	showLoader();
	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseDiscussionComment,
        error: formResponseError
    });
}

function formResponseDiscussionComment(responseText, statusText){
	var form = $('#discussion_comment_form');
	hideLoader();
	enableFormButton(form);
    if(statusText == 'success') {
		if(responseText.type == 'success') {
			resetForm(form);
			$('.topic-comment-list').append(responseText.comment);
			form.find('textarea').val('');
			form.parents('.feed-comment-wrapper').find('.log-msg-wrapper').html('');
            $(".comment-number-text span").text(responseText.commentcounts);
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
			form.parents('.all-comments-data').find('.all-comment-replay').append(responseText.comment);
            // refreshPage();
            form.find('textarea').val('');
			// form.parents('.feed-comment-wrapper').find('.log-msg-wrapper').html('');
			form.parents('.topic-reply-textarea-box').addClass('d-none');
            $(".comment-number-text span").text(responseText.commentcounts);
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

function submitHandlerJoinGroup(form) {
	disableFormButton(form);
	showLoader();
	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseJoinGroup,
        error: formResponseError
    });
}


function formResponseJoinGroup(responseText, statusText){
	var form = $('#joingroup_form');
	hideLoader();
	enableFormButton(form);

	if(statusText == 'success') {
		if(responseText.type == 'success') {
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


$('.report-toggle-menu').on('click', function () {
    $('.report-topic-comment-form').addClass('show');
});
$('.report-cancel-toggle').on('click', function () {
    $('.report-topic-comment-form').removeClass('show');
});

$(document).on('click','.post-cmt-rpl', function(e) {
    e.preventDefault();
    $(this).parents('.topics-comment-list').find('.topic-reply-textarea-box').removeClass('d-none');
    $([document.documentElement, document.body]).animate({
        scrollTop: $(this).parents('.media-comment-item').find('.topic-reply-textarea-box').offset().top - 100
    }, 500);
});

function submitHandlerDeleteDiscussion(form) {
	disableFormButton(form);
	showLoader();
	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseDeleteDiscussion,
        error: formResponseError
    });
}

function formResponseDeleteDiscussion(responseText, statusText){
	var form = $('#delete_discussion_form');
	hideLoader();
	enableFormButton(form);

	if(statusText == 'success') {
		if(responseText.type == 'success') {
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



// $('.close-topic').click(function(){
//     alert('here');
// });
