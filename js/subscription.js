function stripeResponseHandler (status, response) {
    // Grab the form
    var $form = $('#monthlySubscribe');

    if (response.error) {
        $form.find('.payment-errors').text(response.error.message);
        $form.find('.submit').prop('disabled', false); // Re-enable submission
    } else {
        // Get token id
        var token = response.id;

        // Insert token id into form so it gets submitted to server
        $form.append($('<input type="hidden" name="stripeToken">').val(token));

        // Submit form
        $form.get(0).submit();
    }
}

$(function () {
    var $form = $('#monthlySubscribe');
    $form.submit(function (event) {
        // Disable submit to prevent repeated clicks
        $form.find('.submit').prop('disabled', true);

        // Request token from stripe
        Stripe.card.createToken($form, stripeResponseHandler);

        // Prevent the form being submitted
        return false;
    });
});
