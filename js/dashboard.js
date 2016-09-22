var modalSelector = $(".modal");
var logInModalSelector = $("#logInModal");
var deleteDomainModalSelector = $("#deleteDomainModal");
var mainSelector = $("#main");
var domainToDelete;

modalSelector.on('show.bs.modal', function () {
    mainSelector.addClass('blur');
});

modalSelector.on('hide.bs.modal', function () {
    mainSelector.removeClass('blur');
});

deleteDomainModalSelector.on('show.bs.modal', function () {
    mainSelector.addClass('blur');
});

deleteDomainModalSelector.on('hide.bs.modal', function () {
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
        type: "POST",
        url: "/rest/generate.php",
        data: {domain: domain,
            password: password,
            token: token},
        success: function (data, status) {
            passwordField.attr('type', 'text');
            passwordField.val(data);
        },
        error: function (data, status) {
            console.log(data.responseText);
        }
    });
}

function deleteDomain(domain) {
    domainToDelete = domain;
    $("#deleteDomainText").text(domain);
    deleteDomainModalSelector.modal('show');
}

function confirmDeleteDomain(token) {
    $.ajax({
        type: "POST",
        url: "/rest/deletedomain.php",
        data: {domain: domainToDelete,
            token: token},
        success: function (data, status) {
            deleteDomainModalSelector.modal('hide');
            location.reload();
        },
        error: function (data, status) {
            console.log(data.responseText);
        }
    });
}

function addDomain(token) {
    var form = $(this);
    var domain = form.find("#domain").val();
    var password = form.find("#password").val();
    var confirmPassword = form.find("#confirmpassword").val();
    var linkDomain = form.find("#linkdomain").val();

    if (password == confirmPassword) {
        $.ajax({
            type: "POST",
            url: "/rest/createdomain.php",
            data: {domain: domain,
                password: password,
                token: token,
                linkdomain: linkDomain},
            success: function (data, status) {
                location.reload();
            },
            error: function (data, status) {
                console.log(data.responseText);
            }
        });
    }

}