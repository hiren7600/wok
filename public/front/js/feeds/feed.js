var formSelector = null;
var page = 1;
var loading = 0;
var postcount = 0;
var isStopped = 0;
$(document).ready(function() {

	// loadData(page);

	$('.upgradeslider').slick({
	    slidesToShow: 1,
	    slidesToScroll: 1,
	    autoplay: false,
	    autoplaySpeed: 2000,
	    dots:true,
	    arrows:false,
    });

	$.validator.addMethod('filesize', function (value, element, param) {
	    return this.optional(element) || (element.files[0].size <= param * 1000000)
	}, 'File size must be less than {0} MB');

	$('#feed_form').validate({
		ignore: [],
		rules: {
			content: {
				required: function(element) {
					if($('input[name="feedmedia"]')[0].files.length == 0) {
						return true;
					}
					else {
						return false;
					}
				},
			},
			feedmedia: {
				extension: 'jpg,JPG,jpeg,JPEG,png,PNG',
				filesize: 10,
				// extension: 'jpg,jpeg,png,gif,m4v,mov,mp4,wmv,flv',
		  //       filesize: function(element){
				// 	if(element.files[0] !== undefined) {
				// 		fileType = element.files[0]["type"];
				// 		validImageTypes = ['image/jpeg', 'image/jpg', 'image/png'];
				// 		validVideoTypes = ['video/m4v', 'video/mov', 'video/mp4', 'video/wmv', 'video/flv'];

			 //            if(jQuery.inArray(fileType, validImageTypes) != -1) {
				// 		    return 10;
				// 		}
				// 		else if(jQuery.inArray(fileType, validVideoTypes) != -1) {
				// 		    return 100;
				// 		}
				// 	}
		  //       },
			}
		},
		messages: {
			content: {
				required: 'Please enter feed.'
			},
			feedmedia: {
				extension: 'Please select vaild image file.'
			}
		},
        submitHandler:submitHandlerFeed
	});

	$('.cancel-post-btn').on('click',function(e) {
		e.preventDefault();
		resetForm($('#feed_form'));
		$(this).parents('.feed-post-btn-wrapper').removeClass('active');
		$(this).parents('.feed-form-wrap').find('.feed-post-preview').removeClass('active');
    	$(this).parents('.feed-form-wrap').find('.feed-post-preview').find('.preview-img').removeClass('active');
    	$(this).parents('.feed-form-wrap').find('.feed-post-preview').find('.preview-video').removeClass('active');
    	$(this).parents('.feed-form-wrap').find('.feed-post-preview').find('.preview-img').attr('src', '');
    	$(this).parents('.feed-form-wrap').find('.feed-post-preview').find('.preview-video source').attr('src', '');
	});

	$('#content').keyup(function(){
		if($(this).val().length > 0) {
			$('.feed-post-btn-wrapper').addClass('active');
            $(".upload_pic_comment").css("display", "none");
		}
		else {
			$('.feed-post-btn-wrapper').removeClass('active');
            $(".upload_pic_comment").css("display", "block");
		}
	});

	$(document).on('click','.feed-comment-btn', function(e) {
		e.preventDefault();
		formSelector = $(this).parents('.feed-comment-form-wrap').find('form');

		formSelector.validate({
			ignore: [],
			rules: {
				feed_comment: {
					required: function(element) {
						if(formSelector.find('input[name="commentmedia"]')[0].files.length == 0) {
							return true;
						}
						else {
							return false;
						}
					},
				},
				commentmedia: {
					extension: 'jpg,JPG,jpeg,JPEG,png,PNG',
					filesize: 10,
			  //       extension: 'jpg,jpeg,png,gif,m4v,mov,mp4,wmv,flv',
					// filesize: function(element){
					// 	if(element.files[0] !== undefined) {
					// 		fileType = element.files[0]["type"];
					// 		validImageTypes = ['image/gif', 'image/jpeg', 'image/jpg', 'image/png'];
					// 		validVideoTypes = ['video/m4v', 'video/mov', 'video/mp4', 'video/wmv', 'video/flv'];

				 //            if(jQuery.inArray(fileType, validImageTypes) != -1) {
					// 		    return 10;
					// 		}
					// 		else if(jQuery.inArray(fileType, validVideoTypes) != -1) {
					// 		    return 50;
					// 		}
					// 	}
			  //       },
				}
			},
			messages: {
				feed_comment: {
					required: 'Please enter comment.'
				},
				commentmedia: {
					extension: 'Please select vaild image file.'
				}
			},
	        submitHandler:submitHandlerComment
		});

		formSelector.submit();
	});

	$(document).on('keyup','.feed_comment_input', function(e) {
		if($(this).val().length > 0) {
			$(this).parents('.feed-item').find('.feed-comment-btn-wrapper').addClass('active');
            $(".upload_pic_sub_comment").css("display", "none");
            $(".media-upload").css("display", "none");

		}
		else {
			$(this).parents('.feed-item').find('.feed-comment-btn-wrapper').removeClass('active');
            $(".upload_pic_sub_comment").css("display", "block");
            $(".media-upload").css("display", "block");
		}
	});

	$(document).on('click','.post-rpl', function(e) {
		e.preventDefault();
		$(this).parents('.feed-item').find('.feed-form-wrap').removeClass('d-none');
		$([document.documentElement, document.body]).animate({
	        scrollTop: $(this).parents('.feed-item').find('.feed-form-wrap').offset().top - 100
	    }, 500);
	});

	$(document).on('click','.cancel-comment-btn', function(e) {
		e.preventDefault();
		$(this).parents('.feed-item').find('textarea').val('');
		$(this).parents('.feed-item').find('.comment_media_file').val('');
		$(this).parents('.feed-item').find('.feed-form-wrap').addClass('d-none');
		$(this).parents('.feed-item').find('.feed-comment-btn-wrapper').removeClass('active');
	});

	$(document).on('click','.delete-comment', function(e) {
		e.preventDefault();
		var comment_id = $(this).parents('.feed-comment-item').data('comment_id');
		var post_id = $(this).parents('.feed-item').data('id');

	    var formData = new FormData();
	    formData.append('post_id', post_id);
	    formData.append('comment_id', comment_id);

	    $this = $(this);
		$.ajax({
	        url:baseurl() + "/feed/delete/comment",
	        method:"POST",
	        data:formData,
	        contentType:false,
	        cache: true,
	        processData: false,

	        success:function(data){
	            if(data.type == 'success') {
	            	var counter = $('.comment'+data.comment_id).parents('.feed-comment-list').find('.feed-comment-item').length;
	            	console.log(counter);
	            	counter = counter - 1;
	            	console.log(counter);
	            	$('.comment'+data.comment_id).parents('.all-comments-here').find('.show-comment-text').text('Show all '+counter+' comments');
	            	$('.comment'+data.comment_id).remove();
	            }
	            else {
	                showError(data.caption);
	            }
	        },

	    });

	});

	$(document).on('click','.delete-post', function(e) {
		e.preventDefault();
		var post_id = $(this).parents('.feed-item').data('id');

	    var formData = new FormData();
	    formData.append('post_id', post_id);

	    $this = $(this);
		$.ajax({
	        url:baseurl() + "/feed/delete",
	        method:"POST",
	        data:formData,
	        contentType:false,
	        cache: true,
	        processData: false,
	        success:function(data){
	            if(data.type == 'success') {
	            	$('.feed'+data.post_id).remove();
	            }
	            else {
	                showError(data.caption);
	            }
	        },

	    });

	});

	$(document).on('click','.show-comment', function(e) {
		e.preventDefault();
		$(this).parents('.all-comments-here').find('.feed-comment-list').toggleClass('expand');
		if($(this).parents('.all-comments-here').find('.feed-comment-list').hasClass('expand')) {
			// $(this).text('Hide all comments');
			$(this).find('.show-comment-text').addClass('d-none');
			$(this).find('.hide-comment-text').removeClass('d-none');
		}
		else {
			// $(this).text('Show all comments');
			$(this).find('.show-comment-text').removeClass('d-none');
			$(this).find('.hide-comment-text').addClass('d-none');
		}
	})

	$('input[name="feedmedia"]').change(function(e) {
        e.preventDefault();

        $(this).parents('.feed-form-wrap').find('.feed-post-preview').removeClass('active');
    	$(this).parents('.feed-form-wrap').find('.feed-post-preview').find('.preview-img').removeClass('active');
    	$(this).parents('.feed-form-wrap').find('.feed-post-preview').find('.preview-video').removeClass('active');
    	$(this).parents('.feed-form-wrap').find('.feed-post-preview').find('.preview-img').attr('src', '');
    	$(this).parents('.feed-form-wrap').find('.feed-post-preview').find('.preview-video source').attr('src', '');

        var files_list = $(this).get(0).files
        var valid = $('#feed_form').valid();
        if(valid){
        	$(this).parents('.feed-form-wrap').find('.feed-post-btn-wrapper').addClass('active');
        	$this = this;
        	fileType = files_list[0]["type"];
			validImageTypes = ['image/jpeg', 'image/JPEG', 'image/jpg', 'image/JPG', 'image/png', 'image/PNG'];
			validVideoTypes = ['video/m4v', 'video/mov', 'video/mp4', 'video/wmv', 'video/flv'];

            if(jQuery.inArray(fileType, validImageTypes) != -1) {
			    showImage($this, $('.feed-post-preview'));
			}
			else if(jQuery.inArray(fileType, validVideoTypes) != -1) {
			    showVideo($this, $('.feed-post-preview'));
			}

        }

    });

    $(document).on('click', '.preview-close', function(e){
    	$(this).parents('.feed-post-preview').removeClass('active');
    	$(this).parents('.feed-post-preview').find('.preview-img').removeClass('active');
    	$(this).parents('.feed-post-preview').find('.preview-video').removeClass('active');
    	$(this).parents('form').find('input[type="file"]').val('');
    	$(this).parents('.feed-post-preview').find('.preview-img').attr('src', '');
    	$(this).parents('.feed-post-preview').find('.preview-video source').attr('src', '');
    	if($(this).parents('.feed-form-wrap').find('#content').val() == '') {
    		$(this).parents('.feed-form-wrap').find('.feed-post-btn-wrapper').removeClass('active');
    	}
    });

    // $('input[name="commentmedia"]').change(function(e) {
    //     e.preventDefault();
    // 	$(this).parents('.feed-form-wrap').find('.feed-post-btn-wrapper').addClass('active');

    // });


    $(document).on('change', 'input[name="commentmedia"]', function(e) {
        e.preventDefault();

        $(this).parents('.feed-comment-form-wrap').find('.feed-post-preview').removeClass('active');
    	$(this).parents('.feed-comment-form-wrap').find('.feed-post-preview').find('.preview-img').removeClass('active');
    	$(this).parents('.feed-comment-form-wrap').find('.feed-post-preview').find('.preview-video').removeClass('active');
    	$(this).parents('.feed-comment-form-wrap').find('.feed-post-preview').find('.preview-img').attr('src', '');
    	$(this).parents('.feed-comment-form-wrap').find('.feed-post-preview').find('.preview-video source').attr('src', '');

        var files_list = $(this).get(0).files
        formSelector = $(this).parents('.feed_comment_form');
        commentFormInit()
        var valid = formSelector.valid();
        if(valid){
        	$(this).parents('.feed-comment-form-wrap').find('.feed-comment-btn-wrapper').addClass('active');
        	$this = this;
        	fileType = files_list[0]["type"];
			validImageTypes = ['image/jpeg', 'image/JPEG', 'image/jpg', 'image/JPG', 'image/png', 'image/PNG'];
			validVideoTypes = ['video/m4v', 'video/mov', 'video/mp4', 'video/wmv', 'video/flv'];

            if(jQuery.inArray(fileType, validImageTypes) != -1) {
			    showImage($this, $(this).parents('.feed-comment-form-wrap ').find('.feed-post-comment-preview'));
			}
			else if(jQuery.inArray(fileType, validVideoTypes) != -1) {
			    showVideo($this, $(this).parents('.feed-comment-form-wrap ').find('.feed-post-comment-preview'));
			}

        }

    });

    $(document).on('click', '.preview-close', function(e){
    	$(this).parents('.comment-preview-close').removeClass('active');
    	$(this).parents('.comment-preview-close').find('.preview-img').removeClass('active');
    	$(this).parents('.comment-preview-close').find('.preview-video').removeClass('active');
    	$(this).parents('form').find('input[type="file"]').val('');
    	$(this).parents('.comment-preview-close').find('.preview-img').attr('src', '');
    	$(this).parents('.comment-preview-close').find('.preview-video source').attr('src', '');
    	if($(this).parents('.feed-comment-form-wrap').find('.feed_comment_input').val() == '') {
    		$(this).parents('.feed-comment-form-wrap').find('.feed-comment-btn-wrapper').removeClass('active');
    	}
    });

    $(window).scroll(function() {
    	eleheight = $('.welcome-content').outerHeight() + $('footer').outerHeight() + $('#load_more_loader').outerHeight();
		if($(window).scrollTop() + $(window).height() >= ($(document).height() - eleheight)){
			if(loading == 0) { 
	    		page++;
	    		loadData(page);
	    	}
		}
	});

});

function loadData(page) {
	if(isStopped == 0) {
		loading = 1;
    	ajaxFetch(baseurl() + '/feed/load', { page: page }, formResponseFeedLoad, true);
	}
}

function formResponseFeedLoad(responseText, statusText) {

	if(statusText == 'success') {
		// dd(responseText);
		loading = 0;
		postcount = $.parseJSON(responseText).postcount;
		htmldata = $.parseJSON(responseText).htmldata;
		$('#feed-list').append(htmldata);
		
		// postcount
		// isStopped
		if($('.feed-item').length == postcount) {
			isStopped = 1;
			$('#load_more_loader').hide();
		}
	}
	else {
		showError('Unable to communicate with server.');
	}
}

function commentFormInit() {
	formSelector.validate({
		ignore: [],
		rules: {
			feed_comment: {
				required: function(element) {
					if(formSelector.find('input[name="commentmedia"]')[0].files.length == 0) {
						return true;
					}
					else {
						return false;
					}
				},
			},
			commentmedia: {
				extension: 'jpg,JPG,jpeg,JPEG,png,PNG',
				filesize: 10,
			}
		},
		messages: {
			feed_comment: {
				required: 'Please enter comment.'
			},
			commentmedia: {
				extension: 'Please select vaild image file.'
			}
		},
        submitHandler:submitHandlerComment
	});

}

function showVideo($this, selector) {
	selector.addClass('active');
  	selector.find('.preview-video').addClass('active');
  	var $source = selector.find('.preview-video');
  	$source[0].src = URL.createObjectURL($this.files[0]);
  	// $source.load();
}

function showImage($this, selector){
    if ($this.files && $this.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
        	selector.addClass('active');
    		var displayimage = e.target.result;
	    	selector.find('.preview-img').attr('src',displayimage).addClass('active');

        }
        reader.readAsDataURL($this.files[0]);
    }
}

function setCommentCollapsible(selector) {

}

function submitHandlerFeed(form) {
	disableFormButton(form);
	showLoader();
	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseFeed,
        error: formResponseError
    });
}

function formResponseFeed(responseText, statusText){
	var form = $('#feed_form');

	hideLoader();
	enableFormButton(form);

	if(statusText == 'success') {
		if(responseText.type == 'success') {
			resetForm(form);
			$('.feed-post-btn-wrapper').removeClass('active');
			$('#feed-list').prepend(responseText.feed_item);
			$('.log-msg-wrapper').html('');

			form.find('.feed-post-preview').removeClass('active');
	    	form.find('.feed-post-preview').find('.preview-img').removeClass('active');
	    	form.find('.feed-post-preview').find('.preview-video').removeClass('active');
	    	form.find('.feed-post-preview').find('.preview-img').attr('src', '');
	    	form.find('.feed-post-preview').find('.preview-video source').attr('src', '');
            $('.welcome-content').css('display','none');
            $(".upload_pic_comment").css("display", "block");
		}
		else {
			showError(responseText.caption, responseText.errormessage, form.siblings('.feed-wrapper'));
			if(responseText.errorfields !== undefined) {
				highlightInvalidFields(form, responseText.errorfields);
			}
		}
	}
	else {
		showError('Unable to communicate with server.');
	}
}

function submitHandlerComment(form) {
	disableFormButton(form);
	showLoader();
	$(form).ajaxSubmit({
		dataType: 'json',
        success: formResponseComment,
        error: formResponseError
    });
}

function formResponseComment(responseText, statusText){
	var form = formSelector;

	hideLoader();
	enableFormButton(form);

	if(statusText == 'success') {
		if(responseText.type == 'success') {
			resetForm(form);
			form.parents('.feed-item').find('.feed-comment-list').append(responseText.comment);
			form.parents('.feed-item').find('textarea').val('');
			form.parents('.feed-item').find('.comment_media_file').val('');
			form.parents('.feed-item').find('.feed-comment-form-wrap').addClass('d-none');
			form.parents('.feed-item').find('.feed-comment-btn-wrapper').removeClass('active');
			form.parents('.feed-comment-wrapper').find('.log-msg-wrapper').html('');

			form.find('.feed-post-comment-preview').removeClass('active');
	    	form.find('.feed-post-comment-preview').find('.preview-img').removeClass('active');
	    	form.find('.feed-post-comment-preview').find('.preview-video').removeClass('active');
	    	form.find('.feed-post-comment-preview').find('.preview-img').attr('src', '');
	    	form.find('.feed-post-comment-preview').find('.preview-video source').attr('src', '');
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

// $("#content").keyup(function(){
//     if ($(this).val() == "") {
//         $(".upload_pic_comment").css("display", "block");
//     }else{
//         $(".upload_pic_comment").css("display", "none");
//     }
// });
// $(".feed_comment_input").keyup(function(){
//     if ($(this).val() == "") {
//         $(".upload_pic_sub_comment").css("display", "block");
//     }else{
//         $(".upload_pic_sub_comment").css("display", "none");
//     }
// });


