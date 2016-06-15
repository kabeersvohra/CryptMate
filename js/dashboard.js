$('#createDomainModal').on('show.bs.modal', function (e) {
    $('#main').addClass('blur');
});

$('#createDomainModal').on('hide.bs.modal', function (e) {
    $('#main').removeClass('blur');
});

$('#logInModal').each(function () {
    $('#logInModal').modal({
        show: true,
        backdrop: 'static',
        keyboard: false
    });
    $('#main').addClass('blur');
});

