<?php

namespace App\Console\Commands;

use App\Services\Currency\CurrencyRateUpdater;
use Illuminate\Console\Command;

class GetCurrencies extends Command
{
    public function __construct(
        private readonly CurrencyRateUpdater $updater,
    ) {
        parent::__construct();
    }

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
        $this->updater->update();
    }
}
