<?php

namespace App\Listeners;

use App\Events\CreateOrder;
use App\Mail\OrderConfirmation;
use Illuminate\Support\Facades\Mail;

class SendOrderMail
{
    public function __construct(
        private readonly Mail $mail,
    ) {
    }

    public function handle(CreateOrder $event): void
    {
        $order = $event->getOrder();

        if ($order->purchased_currency !== 'GBP') {
            $this->mail::to('837e33b1ec-63022f@inbox.mailtrap.io')
                ->send(new OrderConfirmation($order));
        }
    }
}
