<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Services\Currency\CurrencyConversionCalculator;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\View\View;

class CurrencyController extends BaseController
{
    public function __construct(
        private readonly CurrencyConversionCalculator $calculator,
    ) {
    }

    public function listCurrencies(): View
    {
        $currencies = Currency::query()
            ->where('code', '<>', 'USD')
            ->get()
        ;

        return view('currencies.list', [
            'currencies' => $currencies
        ]);
    }

    public function calculate(): JsonResponse
    {
        $amount = request()->get('amount');
        $currencyId = request()->get('currency');

        $quoteData = $this->calculator->calculate($amount, $currencyId);

        return response()->json([
            'quoteData' => $quoteData
        ]);
    }
}
