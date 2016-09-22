var form = $('#password');

form.submit(function(e) {
    var currentpassword = form.find("#currentpassword").val();
    var newpassword = form.find("#newpassword").val();
    var confirmnewpassword = form.find("#confirmnewpassword").val();
    var token = getCookie('token');

    if (newpassword == confirmnewpassword) {
        $.ajax({
            type: "POST",
            url: "/rest/password.php",
            data: {currentpassword: currentpassword,
                newpassword: newpassword,
                token: token},
            success: function (data, status) {
                console.log("success");
            },
            error: function (data, status) {
                console.log(data.responseText);
            }
        });
    }
    else {
        console.log("passwordsNotMatch")
    }

    return false;
});