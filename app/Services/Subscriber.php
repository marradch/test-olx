<?php

namespace App\Services;

use App\Models\Advert;
use App\Models\AdvertSubscriber;
use App\Exceptions\DuplicateSubscriberException;

class Subscriber
{
    public function subscribe(string $url, string $email)
    {
        $advert = Advert::where('url', $url)->first();

        if (!$advert) {
            $advert = Advert::create(['url' => $url]);
        }

        $subscriber = AdvertSubscriber::where('advert_id', $advert->id)
            ->where('email', $email)->first();

        if ($subscriber) {
            throw new DuplicateSubscriberException('This email is subscribed on this advert');
        } else {
            AdvertSubscriber::create(['advert_id' => $advert->id, 'email' => $email]);
        }
    }
}
