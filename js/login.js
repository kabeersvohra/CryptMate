var form = $('#login');

form.submit(function(e) {
    var username = form.find("#username").val();
    var password = form.find("#password").val();

    $.ajax({
        type: "GET",
        url: "/rest/login.php",
        data: {username: username,
            password: password},
        success: function (data, status) {
            document.cookie = "token=" + data + ";";
            window.location.href = "dashboard.php";
        },
        error: function (data, status) {
            console.log(data);
        }
    });

    return false;
});