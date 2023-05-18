@php
    /** @var \App\Models\Currency[] $currencies */
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Currency Listing</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>

        <!-- Styles -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
        <!-- JS -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    </head>
    <body class="antialiased">
        <script>
            $(document).ready(function() {
                var timeout;
                var amountField = $('#amount');

                amountField.on('keyup', function () {
                    clearTimeout(timeout);
                    timeout = setTimeout(function () {
                        getQuote();
                    }, 2000)
                });

                $('.currency_choice').on('change', function () {
                    getQuote();
                })

                function getQuote() {
                    var amount = amountField.val();
                    var currency = $('input[name="currency"]:checked').val();

                    if (!amount) {
                        alert('Amount is not entered!');
                    }

                    if (!currency) {
                        alert('Currency is not selected');
                    }

                    $.ajax({
                        url: '/api/currency-calculate',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            amount: amount,
                            currency: currency,
                        },
                        success: function (response) {
                            console.log(response);
                            var quoteData = response.quoteData;
                            console.log(quoteData);
                            $('#base_amount').val(quoteData.baseAmount);
                            $('#purchase_amount').val(quoteData.purchaseAmount);
                            $('#surcharge_amount').val(quoteData.surchargeAmount);
                            $('#discount_amount').val(quoteData.discountAmount);
                            $('#total').val(quoteData.total);
                            $('#calculated_data').show();
                        },
                        error: function (response) {
                            alert('Error occurred!');
                        }
                    });
                }
            });
        </script>
        <div class="container">
            <table class="table" style="margin-top: 100px">
                <thead>
                    <tr>
                        <th>Currency Code</th>
                        <th>USD based rate</th>
                        <th>Surcharge %</th>
                        <th>Discount %</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($currencies as $currency)
                        <tr>
                            <td>{{ $currency->code }}</td>
                            <td>{{ $currency->rate }}</td>
                            <td>{{ $currency->surcharge_percent }}</td>
                            <td>{{ $currency->discount_percent }}</td>
                            <td><input type="radio"
                                       {{ ($currency->code === 'EUR') ? "checked" : '' }}
                                       name="currency"
                                       class="currency_choice"
                                       value="{{ $currency->id }}"
                                >
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row">
                <div class="col-sm-12">
                    <label for="amount">Amount</label>
                    <input type="number" name="amount" id="amount">
                    <label for="calculated_amount">Calculated USD amount</label>
                </div>
                <div class="col-sm-12" id="calculated_data" style="display:none">
                    <span>Purchase info:</span>
                    <div>
                        <label for="base_amount">You want:</label>
                        <input id="base_amount">
                        <span id="currency"></span>
                    </div>
                    <div>
                        <label for="purchase_amount">For:</label>
                        <input id="purchase_amount">
                    </div>
                    <div>
                        <label for="surcharge_amount">Our surcharge:</label>
                        <input id="surcharge_amount">
                    </div>
                    <div>
                        <label for="discount_amount">With discount:</label>
                        <input id="discount_amount">
                    </div>
                    <div>
                        <label for="total">Total:</label>
                        <input id="total">
                    </div>
                    <button id="create_order">Purchase</button>
                </div>
            </div>
        </div>
    </body>
</html>
