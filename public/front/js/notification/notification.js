$(document).ready(function () {

    readnotification();

});
function readnotification() {
    var formData = new FormData();
    var user_notification_id = $('input[name=user_notification_id]').val();
    formData.append('user_notification_id', user_notification_id);
    $.ajax({
        url:baseurl() + "/notification-mark-read",
        method: "POST",
        data: formData,
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
            setTimeout(function() {
                $(".new-msg-tag").css("display", "none")
            }, 5000);
        }
    });
};
