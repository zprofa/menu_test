@php
    /** @var \App\Models\Order $order */
@endphp

<div>
    New order is made!
    Total amount: {{ $order->paid_amount_usd + $order->surcharge_amount - $order->discount_amount }}
</div>
