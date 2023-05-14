<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Currency;
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
                  'name' => 'Great Britain Pound',
                  'code' => 'GBP',
                  'rate' =>  0.711178,
                  'surchargePercent' => 0,
                  'discountPercent' => 0,
              ],
              [
                  'name' => 'European Monetary Union EURO',
                  'code' => 'EUR',
                  'rate' =>  0.884872,
                  'surchargePercent' => 0,
                  'discountPercent' => 2,
              ],
              [
                  'name' => 'Japan Yen',
                  'code' => 'JPY',
                  'rate' =>  107.17,
                  'surchargePercent' => 0,
                  'discountPercent' => 0,
              ],
          ];

         \App\Models\User::factory(10)->create();

         foreach ($currencies as $currencyData) {
            $currency = new Currency();
            $currency->name = $currencyData['name'];
            $currency->code = $currencyData['code'];
            $currency->rate = $currencyData['rate'];
            $currency->surcharge_percent = $currencyData['surchargePercent'];
            $currency->discount_percent = $currencyData['discountPercent'];
            $currency->save();
         }

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
