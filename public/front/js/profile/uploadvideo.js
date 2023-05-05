$(document).ready(function(){
    $('#tags').select2({
        // minimumResultsForSearch: -1,
        tags: true,
        maximumSelectionLength: 5
    });
	$([document.documentElement, document.body]).animate({
        scrollTop: 0
    }, 0);

    $.validator.addMethod('filesize', function (value, element, param) {
	    return this.optional(element) || (element.files[0].size <= param * 1048576)
	}, 'File size must be less than {0} MB');

    $('#uploadvideo_form').validate({
    	ignore:'.ignore',
		rules: {
			mediafile: {
                required:true,
				extension: 'm4v,mov,mp4,wmv,flv',
				filesize:  100
			},
            tnc: {
				required: true
			}
		},
		messages: {
			mediafile: {
                required :'Please select video.',
				extension: 'Please select m4v, mov, mp4, wmv or flv file.'
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
                document.querySelector('#mediafile').files = e.originalEvent.dataTransfer.files;

                var valid = $('#mediafile').valid();

		        if(valid){
		            $this = document.querySelector('#mediafile');
		            showVideo($this, $('.feed-post-preview'));
		            // setTimeout(function () {
		            // 	createPoster(document.querySelector(".preview-video"));
		            // },1000);
		        }
		        else{
		        	$('.preview-close').trigger('click');
		        }

            }
            if(files_list.length == 0){
                $('#mediafile').val('');
            }

    });

    $('.preview-close').click(function(e){
    	e.preventDefault();
    	$(this).parents('.feed-post-preview').removeClass('active');
    	$(this).parents('form').find('input[type="mediafile"]').val('');
    	$(this).parents('.feed-post-preview').find('.preview-video source').attr('src', '');
    	$('.btn-upload-photo span').text('Select video to upload');
    });

    $('#mediafile').change(function(e) {
        e.preventDefault();
        var files_list = $(this).get(0).files

        var valid = $('#mediafile').valid();
        if(valid){
            $this = this;
            showVideo($this, $('.feed-post-preview'));
            // setTimeout(function () {
            // 	createPoster(document.querySelector(".preview-video"));
            // },1000);

        }
        else{
        	$('.preview-close').trigger('click');
        }

    });

 //    function createPoster(file) {

 //    	var video1 = document.createElement('video');
	//     video1.src = URL.createObjectURL(file);
	//     console.log(file);
	// 	setTimeout(function() {
	// 	    currentduration = video1.duration;
	//     	console.log(currentduration);
	//     	duration = 10;
	//     	if(currentduration <= 10 ) {
	//     		duration = currentduration/2;
	//     	}
	//     	console.log(duration);

	//     	var video = document.createElement('video');
	// 	    video.src = URL.createObjectURL(file)+'#t='+duration;
	// 	    setTimeout(function() {
	//     		console.log(video.src);
	//     		console.log(video.videoWidth);
	//     		console.log(video.videoHeight);
	// 		    var canvas = document.createElement("canvas");
	// 		    canvas.width = video.videoWidth/2;
	// 		    canvas.height = video.videoHeight/2;
	// 		    canvas.getContext("2d").drawImage(video, 0, 0, canvas.width, canvas.height);
	// 		    // $video.currentTime = 0;
	// 		    var dataURI = canvas.toDataURL("image/png");
	// 		    $('#thumbimage').val(dataURI);

	// 	    },700);
	//     },300);
	// }

	 function createPoster(file, imdDuration) {
	 	console.log('imdDuration => ', imdDuration);
		var fileReader = new FileReader();

		fileReader.onload = function() {
		    var blob = new Blob([fileReader.result], {
		        type: file.type
		    });
		    var url = URL.createObjectURL(blob);
		    var video = document.createElement('video');
		    var timeupdate = function() {
		        if (snapImage()) {
		            video.removeEventListener('timeupdate', timeupdate);
		            video.pause();
		        }
		    };
		    video.addEventListener('loadeddata', function() {
		        if (snapImage()) {
		            video.removeEventListener('timeupdate', timeupdate);
		        }
		    });
		    var snapImage = function() {
		    	// console.log(video.duration);
		        var canvas = document.createElement('canvas');
		        canvas.width = video.videoWidth/2;
		        canvas.height = video.videoHeight/2;
		        canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
		        var image = canvas.toDataURL("image/jpeg");
		        var success = image.length > 100000;
		        // if (success) {
		            $('#thumbimage').val(image);
		            URL.revokeObjectURL(url);
		        // }
		        return success;
		    };
		    video.addEventListener('timeupdate', timeupdate);
		    video.preload = 'metadata';
		    video.src = url+'#t='+imdDuration;

		    // Load video in Safari / IE11
		    video.muted = true;
		    video.playsInline = true;
		    video.play();
		};
		fileReader.readAsArrayBuffer(file);
	}

    function showVideo($this, selector) {
		selector.addClass('active');
	  	var $source = selector.find('.preview-video');

    	$source[0].src = URL.createObjectURL($this.files[0]);
  		$('.btn-upload-photo span').text('Select video to re-upload');

	    setTimeout(function() {
	  		//get duration fro uploaded video
	    	currentduration = $source[0].duration;
	    	duration = 10;
	    	if(currentduration <= 10 ) {
	    		duration = currentduration/2;
	    	}
	    	createPoster($this.files[0], duration);
	    },300);

	  	// $source.load();
	}

 //    function createPoster($video) {
	//     var canvas = document.createElement("canvas");
	//     canvas.width = $video.videoWidth/2;
	//     canvas.height = $video.videoHeight/2;
	//     canvas.getContext("2d").drawImage($video, 0, 0, canvas.width, canvas.height);
	//     $video.currentTime = 0;
	//     var dataURI = canvas.toDataURL("image/jpeg");
	//     $('#thumbimage').val(dataURI);
	// }

 //    function showVideo($this, selector) {
	// 	selector.addClass('active');
	//   	var $source = selector.find('.preview-video');

	//   	//get duration fro uploaded video
	//   	var video = document.createElement('video');
	//     video.src = URL.createObjectURL($this.files[0]);
	//     setTimeout(function() {
	//     	currentduration = video.duration;
	//     	duration = 10;
	//     	if(currentduration <= 10 ) {
	//     		duration = currentduration/2;
	//     	}
	//     	$source[0].src = URL.createObjectURL($this.files[0])+'#t='+duration;
	//   		$('.btn-upload-photo span').text('Select video to re-upload');
	//     },300);

	//   	// $source.load();
	// }

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
	var form = $('#uploadvideo_form');
	// hideLoader();
	enableFormButton(form);

	if(statusText == 'success') {
		if(responseText.type == 'success') {
			resetForm(form);
            window.location.reload();
			// $('.progress-wrapper').removeClass('active');
   //          $('.progress-wrapper .file-progress').attr('data-progresstext', '0%');
   //          $('.progress-wrapper .file-progress .progress__bar').css('width', '0%');
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
