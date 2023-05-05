$(document).ready(function () {
    $(".add-and-remo").on("click", function (e) {
        e.preventDefault();
        $(this).parent().parent().toggleClass('myshow');
    })
});


$('.add-and-remo').click(function(){
    var formData = new FormData();
    var tag_id = $(this).data('tag_id');
    formData.append('tag_id', tag_id);
    $.ajax({
        url:baseurl() + "/kink",
        method: "POST",
        data: formData,
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
            // setTimeout(function() {
            //     $(".new-msg-tag").css("display", "none")
            // }, 5000);
        }
    });
});



