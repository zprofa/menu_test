<?php

namespace App\Services\Order;

use App\Models\Currency;
use Illuminate\Http\Request;

class Validator
{
    public function validate(Request $request): void
    {
        $currencyCodes = Currency::query()
            ->where('code', '<>', 'USD')
            ->pluck('code')
            ->toArray()
        ;
        $currencyCodes = implode(',', $currencyCodes);

        $request->validate([
            'orderData.currency' => "required|in:$currencyCodes",
            'orderData.paidAmount' => 'required|gt:0',
            'orderData.purchaseAmount' => 'required|gt:0',
            'orderData.surchargeAmount' => 'required|gt:0',
            'orderData.surchargePercent' => 'required|gt:0',
            'orderData.total' => 'required|gt:0',
        ]);
    }
}
