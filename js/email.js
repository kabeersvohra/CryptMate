var form = $('#email');

form.submit(function(e) {
    var currentemail = form.find("#currentemail").val();
    var newemail = form.find("#newemail").val();
    var token = getCookie('token');

    $.ajax({
        type: "POST",
        url: "/rest/email.php",
        data: {currentemail: currentemail,
            newemail: newemail,
            token: token},
        success: function (data, status) {
            console.log("success");
        },
        error: function (data, status) {
            console.log(data.responseText);
        }
    });

    return false;
});