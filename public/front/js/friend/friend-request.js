$(document).ready(function() {
	$('.approve-btn').click(function(e) {
		from_user_id = $(this).parents('.friend-item').data('from_user_id');

		var formData = new FormData();
	    formData.append('user_id', from_user_id);

	    $this = $(this);
		$.ajax({
	        url:baseurl() + "/friend-request-accept",
	        method:"POST",
	        data:formData,
	        contentType:false,
	        cache: true,
	        processData: false,

	        success:function(data){
	            if(data.type == 'success') {
	            	$('.friend'+from_user_id).remove();
	            	refreshPage();
	            }
	            else {
	                showError(data.caption);
	            }
	        },

	    });
	});

	$('.decline-btn').click(function(e) {
		from_user_id = $(this).parents('.friend-item').data('from_user_id');

		var formData = new FormData();
	    formData.append('user_id', from_user_id);

	    $this = $(this);
		$.ajax({
	        url:baseurl() + "/friend-request-decline",
	        method:"POST",
	        data:formData,
	        contentType:false,
	        cache: true,
	        processData: false,

	        success:function(data){
	            if(data.type == 'success') {
	            	$('.friend'+from_user_id).remove();
	            	refreshPage();
	            }
	            else {
	                showError(data.caption);
	            }
	        },

	    });
	});
});
