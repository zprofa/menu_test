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
        <style>
            #calculated_data .label {
                width: 200px;
                display: inline-block;
                color: black;
                text-align: left;
                font-size: 14px;
                font-weight: normal;
                padding-left: 0;
            }
        </style>
        <!-- JS -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    </head>
    <body class="antialiased">
        <script>
            $(document).ready(function() {
                var timeout;
                var amountField = $('#amount');
                window.quoteData = null;

                amountField.on('keyup', function () {
                    clearTimeout(timeout);
                    timeout = setTimeout(function () {
                        getQuote();
                    }, 2000)
                });

                $('.currency_choice').on('change', function () {
                    getQuote();
                })

                $('#create_order').on('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();

                    if (!window.quoteData) {
                        alert('Something is wrong, did you entered currency and amount?');
                        return;
                    }

                    $.ajax({
                        url: '/api/orders/create',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            orderData: window.quoteData
                        },
                        success: function (response) {
                            console.log(response);
                        },
                        error: function (response) {
                            alert('Error occurred!');
                        }
                    });
                })

                function getQuote() {
                    var amount = amountField.val();
                    var currency = $('input[name="currency"]:checked').val();

                    if (!amount) {
                        alert('Amount is not entered!');
                        return;
                    }

                    if (!currency) {
                        alert('Currency is not selected');
                        return;
                    }

                    $.ajax({
                        url: '/api/currencies/calculate',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            amount: amount,
                            currency: currency,
                        },
                        success: function (response) {
                            var quoteData = response.quoteData;
                            window.quoteData = quoteData
                            $('#paid_amount').text(quoteData.paidAmount);
                            $('#purchase_amount').text(quoteData.purchaseAmount);
                            $('#surcharge_amount').text(quoteData.surchargeAmount);
                            $('#discount_amount').text(quoteData.discountAmount);
                            $('#total').text(quoteData.total);
                            $('#currency_code').text(quoteData.currency);
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
                    <h2>Purchase info:</h2>
                    <div>
                        <span class="label">You want:</span>
                        <span id="purchase_amount"></span>
                        <span id="currency_code"></span>
                    </div>
                    <div>
                        <span class="label">For:</span>
                        <span id="paid_amount"></span>
                    </div>
                    <div>
                        <span class="label">Our surcharge:</span>
                        <span id="surcharge_amount"></span>&nbsp;USD
                    </div>
                    <div>
                        <span class="label">Total:</span>
                        <span id="total"></span>
                    </div>
                    <button id="create_order">Purchase</button>
                </div>
            </div>
        </div>
    </body>
</html>
