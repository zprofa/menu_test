<?php

namespace App\Services\Currency;

use App\Models\Currency;
use App\Services\DTO\QuoteData;

class CurrencyConversionCalculator
{
    public function calculate(float $amount, int $currencyId): QuoteData
    {
        /** @var Currency $currency */
        $currency = Currency::find($currencyId);
        $dto = new QuoteData();
        $dto->purchaseAmount = round($amount, 2);
        $dto->currency = $currency->code;

        $this->calculatePaidAmount($currency, $dto);
        $this->calculateSurcharge($currency, $dto);
        // In some real world example discount calc would come here?
        // Since task is clear that it should happen on order create I will move it there.

        $dto->total = round($dto->paidAmount + $dto->surchargeAmount, 2);

        return $dto;
    }

    private function calculatePaidAmount(
        Currency $currency,
        QuoteData $dto,
    ): void {
        $dto->paidAmount = round($dto->purchaseAmount * (1 / $currency->rate), 2);
    }

    private function calculateSurcharge(
        Currency $currency,
        QuoteData $dto,
    ): void {
        $surchargePercent = $currency->surcharge_percent;

        if (!$surchargePercent) {
            $dto->surchargePercent = 0;
            $dto->surchargeAmount = 0;

            return;
        }

        $dto->surchargeAmount = round($dto->purchaseAmount * ($surchargePercent / 100), 2);
        $dto->surchargePercent = $surchargePercent;
    }
}
