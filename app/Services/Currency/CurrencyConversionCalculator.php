<?php

namespace App\Services\Currency;

use App\Models\Currency;

class CurrencyConversionCalculator
{
    public function calculate(float $amount, int $currencyId): CurrencyDTO
    {
        /** @var Currency $currency */
        $currency = Currency::find($currencyId);
        $dto = new CurrencyDTO();
        $dto->baseAmount = round($amount, 2);

        $this->calculatePurchaseAmount($currency, $dto);
        $this->calculateSurcharge($currency, $dto);
        $this->calculateDiscount($currency, $dto);

        $dto->total = round($dto->purchaseAmount + $dto->surchargeAmount - $dto->discountAmount, 2);

        return $dto;
    }

    private function calculatePurchaseAmount(
        Currency $currency,
        CurrencyDTO $dto,
    ): void {
        $dto->purchaseAmount = round($dto->baseAmount * (1 / $currency->rate), 2);
    }

    private function calculateSurcharge(
        Currency $currency,
        CurrencyDTO $dto,
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

    private function calculateDiscount(
        Currency $currency,
        CurrencyDTO $dto,
    ): void {
        $discountPercent = $currency->discount_percent;

        if (!$discountPercent) {
            $dto->discountPercent = 0;
            $dto->discountAmount = 0;

            return;
        }

        $dto->discountAmount = round($dto->purchaseAmount * ($discountPercent / 100), 2);
        $dto->discountPercent = $discountPercent;
    }
}
