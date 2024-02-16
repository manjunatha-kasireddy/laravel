$("#current_Pwd").blur(function() {
    var my_password = $("#current_Pwd").val();
    alert(my_password);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url: '/admin/check-current-password',
        data: { current_Pwd: my_password },
        success: function(response) {
            alert(response);
            if (response == "false") {
                $("#verifyCurrentPwd").text('Current password is Incorrect!');
            } else if (response == "true") {
                $("#verifyCurrentPwd").text("Current Password is correct!");
            }
        },
        error: function() {

            alert('Error');
        }
    });
});

$(document).on("click", ".updateCmsPageStatus", function() {
    var status = $(this).children("i").attr("status");
    alert(status);
    var page_id = $(this).attr("page_id");
    alert(page_id);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url: '/admin/update-cms-page-status',
        data: { status: status, page_id: page_id },
        success: function(response) {
            if (response['status'] == 0) {
                $("#page-" + page_id).html("<i class='fas fa-toggle-off' style = 'color:red' status = 'Inactive' > ");
            } else if (response['status'] == 1) {
                $("#page-" + page_id).html("<i class='fas fa-toggle-on' status = 'Inactive' > ");
            }
        },
        error: function() {
            alert("Error");
        }
    });
});


$(document).ready(myReadyFunction);