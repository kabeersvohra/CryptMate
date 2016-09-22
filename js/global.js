function deleteAccount(token) {
    $.ajax({
        type: "POST",
        url: "/rest/deleteaccount.php",
        data: {token: token},
        success: function (data, status) {
            var url = 'deleted.php';
            var form = $('<form action="' + url + '" method="post">' +
                '<input type="text" name="deleted" value="true" />' +
                '</form>');
            $('body').append(form);
            form.submit();
        },
        error: function(data, status) {
            console.log(data.responseText);
        }
    });
}

function getCookie(name) {
    var value = "; " + document.cookie;
    var parts = value.split("; " + name + "=");
    if (parts.length == 2) return parts.pop().split(";").shift();
}