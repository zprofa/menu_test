<?php

namespace App\Listeners;

use App\Events\CreateOrder;
use App\Models\Currency;

class ApplyDiscount
{
    public function handle(CreateOrder $event): void
    {
        $order = $event->getOrder();

        /** @var Currency $currency */
        $currency = Currency::query()
            ->where('code', '=', $order->purchased_currency)
            ->first()
        ;

        if (!$currency->discount_percent) {
            return;
        }

        $order->discount_amount = round($order->paid_amount_usd * ($currency->discount_percent / 100), 2);
        $order->discount_percent = $currency->discount_percent;
    }
}
