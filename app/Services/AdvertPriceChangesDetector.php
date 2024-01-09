<?php

namespace App\Services;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\Advert;
use App\Notifications\PriceChangeNotification;
use Illuminate\Support\Facades\Notification;

class AdvertPriceChangesDetector
{
    public function __construct(
        protected PriceDetector $priceDetector,
    ) {}

    public function detectPriceChanges(Command $consoleCommand = null) : void
    {
        $adverts = Advert::has('subscribers')->with('subscribers')->get();

        foreach ($adverts as $advert) {
            try {
                $olxCurrentPrice = $this->priceDetector->getPriceByUrl($advert->url);
            } catch (\Exception $e) {
                $message = "Error in price detection: {$e->getMessage()}";
                $consoleCommand?->error($message);
                Log::error($message);

                continue;
            }

            if (empty($advert->price)) {
                $advert->price = $olxCurrentPrice;
                $advert->save();

                continue;
            }

            if ($advert->price !== $olxCurrentPrice) {
                $message = "Price change for advert detected: {$advert->url}";
                $consoleCommand?->info($message);
                Log::info($message);

                $oldPrice = $advert->price;
                $advert->price = $olxCurrentPrice;
                $advert->save();

                try {
                    Notification::route('mail', $advert->subscribers->pluck('email')->toArray())->notify(
                        new PriceChangeNotification($advert->url, $oldPrice, $advert->price)
                    );
                } catch (\Exception $e) {
                    $message = "Error in price detection mail: {$e->getMessage()}";
                    $consoleCommand?->error($message);
                    Log::error($message);

                    continue;
                }

            }
        }
    }
}
