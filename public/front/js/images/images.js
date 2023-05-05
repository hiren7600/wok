var page = 1;
var loading = 0;
var imagecount = 0;
var isStopped = 0;
$(document).ready(function() {

    $(window).scroll(function() {
    	eleheight = $('footer').outerHeight() + $('#load_more_loader').outerHeight();
		if($(window).scrollTop() + $(window).height() >= ($(document).height() - eleheight)){
			if(loading == 0) { 
	    		page++;
	    		loadData(page);
	    	}
		}
	});

	setInterval(function(){
	    resizeAllGridItems();
	}, 500);

});

function loadData(page) {
	if(isStopped == 0) {
		loading = 1;
    	ajaxFetch(baseurl() + '/image/load', { page: page }, formResponseFeedLoad, true);
	}
}

function formResponseFeedLoad(responseText, statusText) {

	if(statusText == 'success') {
		// dd(responseText);
		loading = 0;
		iamgecount = $.parseJSON(responseText).iamgecount;
		htmldata = $.parseJSON(responseText).htmldata;
		$('#image-items').append(htmldata);
		resizeAllGridItems();
		// postcount
		// isStopped
		if($('.item').length == iamgecount) {
			isStopped = 1;
			$('#load_more_loader').hide();
		}
	}
	else {
		showError('Unable to communicate with server.');
	}
}

