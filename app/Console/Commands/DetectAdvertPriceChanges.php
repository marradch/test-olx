<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\AdvertPriceChangesDetector;

class DetectAdvertPriceChanges extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:detect-advert-price-changes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $advertPriceChangesDetector = resolve(AdvertPriceChangesDetector::class);
        $advertPriceChangesDetector->detectPriceChanges($this);
    }
}
