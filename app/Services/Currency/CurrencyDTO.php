<?php

namespace App\Services\Currency;

class CurrencyDTO
{
    public float $baseAmount;
    public float $purchaseAmount;
    public string $currency;
    public float $surchargeAmount;
    public int $surchargePercent;
    public float $discountAmount;
    public int $discountPercent;
    public float $total;
}
