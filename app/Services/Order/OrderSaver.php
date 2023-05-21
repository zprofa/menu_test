<?php

namespace App\Services\Order;

use App\Events\CreateOrder;
use App\Models\Currency;
use App\Models\Order;

class OrderSaver
{
    public function save(array $orderData): Order
    {
        /** @var Currency $currency */
        $currency = Currency::query('c')
            ->where('code', '=', $orderData['currency'])
            ->first()
        ;

        $order = new Order();
        $order->rate = $currency->rate;
        $order->purchased_currency = $currency->code;
        $order->purchased_amount = $orderData['purchaseAmount'];
        $order->paid_amount_usd = $orderData['paidAmount'];
        $order->surcharge_percent = $orderData['surchargePercent'];
        $order->surcharge_amount = $orderData['surchargeAmount'];
        $order->save();

        CreateOrder::dispatch($order);

        return $order;
    }
}
