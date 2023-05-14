<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GetCurrencies extends Command
{
    private const CURRENCY_API_METHOD = 'GET';
    private const CURRENCY_API_URL = 'https://api.apilayer.com/currency_data/live?source=%s&currencies=%s';
    private const CURRENCY_HEADER = 'apikey: %s';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-currencies';

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
        //
    }
}
