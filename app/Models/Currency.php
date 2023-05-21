<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int    $id
 * @property string $name
 * @property string $code
 * @property float  $rate
 * @property float  $surcharge_percent
 * @property float  $discount_percent
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Currency extends Model
{
    protected $table = 'currency';
}
