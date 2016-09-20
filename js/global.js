function deleteAccount(token) {
    $.ajax({
        type: "GET",
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

        }
    });
}