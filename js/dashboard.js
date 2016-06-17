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

