$(document).ready(function () {
    var SITEURL = window.location.origin;

    var paypalAmount = $('.paypal_price_hidden').val();


    function initPayPalButton(paypalAmount) {

           // Render the PayPal button into #paypal-button-container
           paypal.Buttons({

            createOrder: function (data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        "amount": {
                            "currency_code": "EUR",
                            "value": paypalAmount
                        }
                    }]
                });
            },

            // Call your server to set up the transaction
            // createOrder: function(data, actions) {
            //     return fetch(SITEURL + '/payment-checkout/create-order', {
            //         method: 'post',
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //         },
            //     }).then(function(res) {
            //         return res.json();
            //     }).then(function(orderData) {
            //         return orderData.id;
            //     });
            // },

            // Call your server to finalize the transaction
            onApprove: function(data, actions) {
                return fetch(SITEURL + '/payment-checkout/capture/' + data.orderID + '/capture/', {
                    method: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                }).then(function(res) {
                    return res.json();
                }).then(function(orderData) {
                    // Three cases to handle:
                    //   (1) Recoverable INSTRUMENT_DECLINED -> call actions.restart()
                    //   (2) Other non-recoverable errors -> Show a failure message
                    //   (3) Successful transaction -> Show confirmation or thank you

                    // This example reads a v2/checkout/orders capture response, propagated from the server
                    // You could use a different API or structure for your 'orderData'
                    var errorDetail = Array.isArray(orderData.details) && orderData.details[0];

                    if (errorDetail && errorDetail.issue === 'INSTRUMENT_DECLINED') {
                        return actions.restart(); // Recoverable state, per:
                        // https://developer.paypal.com/docs/checkout/integration-features/funding-failure/
                    }

                    if (errorDetail) {
                        var msg = 'Sorry, your transaction could not be processed.';
                        if (errorDetail.description) msg += '\n\n' + errorDetail.description;
                        if (orderData.debug_id) msg += ' (' + orderData.debug_id + ')';
                        return alert(msg); // Show a failure message (try to avoid alerts in production environments)
                    }

                    // Successful capture! For demo purposes:
                   // console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                    // var transaction = orderData.purchase_units[0].payments.captures[0];
                    // alert('Transaction '+ transaction.status + ': ' + transaction.id + '\n\n thanks for the payment See console for all available details');
                    const element = document.getElementById('paypal-button-container');
                    element.innerHTML = '';
                    element.innerHTML = '<h3>Thanks for your payment!</h3>';

                    // Replace the above to show a success message within this page, e.g.
                    // const element = document.getElementById('paypal-button-container');
                    // element.innerHTML = '';
                    // element.innerHTML = '<h3>Thank you for your payment!</h3>';
                    // Or go to another URL:  actions.redirect('thank_you.html');
                });
            }

        }).render('#paypal-button-container');

        paypal.Buttons({
            style: {
                shape: 'pill',
                color: 'blue',
                layout: 'horizontal',
                label: 'pay',
                tagline: true
            },

            createOrder: function (data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        "amount": {
                            "currency_code": "EUR",
                            "value": paypalAmount
                        }
                    }]
                });
            },

            onApprove: function (data, actions) {
                return actions.order.capture().then(function (orderData) {

                    // Full available details
                    console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));

                    // Show a success message within this page, e.g.
                    const element = document.getElementById('paypal-button-container');
                    element.innerHTML = '';
                    element.innerHTML = '<h3>Thanks for your payment!</h3>';

                    // Or go to another URL:  actions.redirect('thank_you.html');


                    axios.post('/test', {
                        headers: {
                            'content-type' : 'application/json'
                        }
                    })
                    .then(res => {
                        this.totalPrice = res.data
                        window.location.replace("/asas");
                    })
                    .catch(err => console.log(err))


                });
            },

            onError: function (err) {
                console.log(err);
            }
        }).render('#paypal-button-container');
    }
    initPayPalButton(paypalAmount);


    $(".paypal_price").click(function () {

        paypalAmount = $(this).val();


        const element = document.getElementById('paypal-button-container');
        element.innerHTML = '';

        initPayPalButton(paypalAmount);

    });




}
);