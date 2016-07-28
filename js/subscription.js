var form;

$(document).ready(function (e) {
    $('#checkout').submit(function (e) {

        form = $(this);

        // form.find('button').prop('disabled', true);

        var number = form.find('#ccnumber').val();
        var securitycode = form.find('#securitycode').val();
        var exp = form.find('#expdate').val().split("/");

        Stripe.card.createToken({
            number: number,
            cvc: securitycode,
            exp_month: exp[0],
            exp_year: exp[1]
        }, formSubmit);
        return false;
    });
});

function formSubmit (status, response) {
    alert(status);
    if(response.error) {
        $('.message-wrapper').addClass('alert alert-danger').text(response.error.message);
        form.find('button').prop('disabled', false);
    }
    else {
        var token = response.id;
        $.ajax({
            url: '/processing/stripe.php',
            type: 'POST',
            data: {stripeToken: token},
            success: stripeSuccess
        });
    }
}

function stripeSuccess(status, response) {
    alert(status, response);
    if (response.error) {
        $('.message-wrapper').addClass('alert alert-danger').text(response.error);
    }
    else {
        $.ajax({
            type: "POST",
            url: "/processing/stripe.php",
            data: {stripeToken: token},
            success: stripeResponseSuccess,
            error: stripeResponseFail
        });
    }
}

function stripeResponseSuccess(data, status){
    alert("Data: " + data + "\nStatus: " + status);
}

function stripeResponseFail(data, status) {
    alert("Data: " + data + "\nStatus: " + status);
}