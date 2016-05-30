$('#createDomainModal').on('show.bs.modal', function (e) {
    $('#maincontainer').addClass('blur');
});

$('#createDomainModal').on('hide.bs.modal', function (e) {
    $('#maincontainer').removeClass('blur');
});

