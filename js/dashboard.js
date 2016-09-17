var modalSelector = $(".modal");
var logInModalSelector = $("#logInModal");
var mainSelector = $("#main");

modalSelector.on('show.bs.modal', function () {
    mainSelector.addClass('blur');
});

modalSelector.on('hide.bs.modal', function () {
    mainSelector.removeClass('blur');
});

logInModalSelector.each(function () {
    logInModalSelector.modal({
        show: true,
        backdrop: 'static',
        keyboard: false
    });
    mainSelector.addClass('blur');
});

function generatePassword(passwordField, domain, token) {
    var password = passwordField.val();
    $.ajax({
        type: "GET",
        url: "/rest/generate.php",
        data: {domain: domain,
            password: password,
            token: token},
        success: function (data, status) {
            passwordField.attr('type', 'text');
            passwordField.val(data);
        },
        error: function (data, status) {
            console.log(data);
        }
    });
}