<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
          $currencies = [
              [
                  'name' => 'US Dolar',
                  'code' => 'USD',
                  'rate' =>  1,
                  'surchargePercent' => 0,
                  'discountPercent' => 0,
              ],
              [
                  'name' => 'Great Britain Pound Sterling',
                  'code' => 'GBP',
                  'rate' =>  0.711178,
                  'surchargePercent' => 5,
                  'discountPercent' => 0,
              ],
              [
                  'name' => 'European Monetary Union EURO',
                  'code' => 'EUR',
                  'rate' =>  0.884872,
                  'surchargePercent' => 5,
                  'discountPercent' => 2,
              ],
              [
                  'name' => 'Japan Yen',
                  'code' => 'JPY',
                  'rate' =>  107.17,
                  'surchargePercent' => 7.5,
                  'discountPercent' => 0,
              ],
          ];

         User::factory(1)->create();

         foreach ($currencies as $currencyData) {
            $currency = new Currency();
            $currency->name = $currencyData['name'];
            $currency->code = $currencyData['code'];
            $currency->rate = $currencyData['rate'];
            $currency->surcharge_percent = $currencyData['surchargePercent'];
            $currency->discount_percent = $currencyData['discountPercent'];
            $currency->save();
         }
    }
}
