<?php

namespace App\Console\Commands;

use App\Models\Currency;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GetCurrencies extends Command
{
    private const CURRENCY_API_URL = 'https://api.apilayer.com/currency_data/live?source=%s&currencies=%s';
    private const CURRENCY_HEADER = 'apikey';
    private const BASE_CURRENCY = 'USD';
    private const UPDATABLE_CURRENCIES = 'EUR,JPY,GBP';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:currencies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the rates of currencies';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $apiKey = env('CURRENCY_API_KEY');

            $url = sprintf(self::CURRENCY_API_URL,
                self::BASE_CURRENCY,
                self::UPDATABLE_CURRENCIES
            );

            $response = Http::withHeaders([self::CURRENCY_HEADER => $apiKey])->get($url);
            $responseBody = json_decode($response->body(), true);

            foreach ($responseBody['quotes'] as $key => $rate) {
                $key = str_replace(self::BASE_CURRENCY, '', $key);

                /** @var Currency $targetCurrency */
                $targetCurrency = Currency::query()
                    ->where('currency.code', '=', $key)
                    ->first();

                $targetCurrency->rate = $rate;
                $targetCurrency->save();
            }

            Log::info('Currencies updated!');
        } catch (\Throwable $t) {
            Log::error('Error happened while trying to update currencies', [
                'Message' => $t->getMessage(),
            ]);
        }
    }
}
