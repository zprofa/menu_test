<?php

namespace App\Services\DTO;

class QuoteData
{
    public float $paidAmount;
    public float $purchaseAmount;
    public string $currency;
    public float $surchargeAmount;
    public int $surchargePercent;
    public float $total;
}
