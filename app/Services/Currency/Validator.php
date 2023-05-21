<?php

namespace App\Services\Currency;

use App\Models\Currency;
use Illuminate\Http\Request;

class Validator
{
    public function validate(Request $request): void
    {
        $currencyIds = Currency::query()
            ->where('code', '<>', 'USD')
            ->pluck('id')
            ->toArray()
        ;
        $currencyIds = implode(',', $currencyIds);

        $request->validate([
            'amount' => 'required|gt:0',
            'currency' => "required|in:$currencyIds",
        ]);
    }
}
