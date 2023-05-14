<?php

namespace App\Models;

use Carbon\Carbon;

/**
 * @property int    $id
 * @property string $purchased_currency
 * @property string $purchased_amount
 * @property string $paid_amount_usd
 * @property string $rate
 * @property float  $surcharge_percent
 * @property float  $surcharge_amount
 * @property float  $discount_percent
 * @property float  $discount_amount
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Order
{

}
/*
 * Foreign currency purchased.• Exchange rate for foreign currency.• Surcharge percentage.• Amount of surcharge.•
 *  Amount of foreign currency purchased.• Amount paid in USD.• Discount percentage• Discount amount• Date created
 */
