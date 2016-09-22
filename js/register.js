var form = $('#register');

form.submit(function(e) {
    var username = form.find("#username").val();
    var email = form.find("#email").val();
    var password = form.find("#password").val();
    var confirmPassword = form.find("#confirmpassword").val();

    $.ajax({
        type: "POST",
        url: "/rest/login.php",
        data: {username: username,
            password: password},
        success: function (data, status) {
            document.cookie = "token=" + data + ";";
            window.location.href = "dashboard.php";
        },
        error: function (data, status) {
            console.log(data.responseText);
        }
    });

    return false;
});
