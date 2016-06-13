$('#createDomainModal').on('show.bs.modal', function (e) {
    $('#main').addClass('blur');
});

$('#createDomainModal').on('hide.bs.modal', function (e) {
    $('#main').removeClass('blur');
});

