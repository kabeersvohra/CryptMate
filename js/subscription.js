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
        }, stripeSuccess);
        return false;
    });
});

function stripeSuccess(status, response) {
    if (response.error) {
        $('.message-wrapper').addClass('alert alert-danger').text(response.error.message);
    }
    else {
        var token = response.id;
        $.ajax({
            type: "POST",
            url: "/processing/stripe.php",
            data: {stripeToken: token,
                stripePlan: "monthly",
                subscribe: true},
            success: stripeResponseSuccess,
            error: stripeResponseFail
        });
    }
}

function stripeResponseSuccess(data, status){
    alert("Data: " + data + "\nStatus: " + status);
    console.log(data);
    console.log(status);
}

function stripeResponseFail(data, status) {
    alert("Data: " + data + "\nStatus: " + status);
    console.log(data);
    console.log(status);
}