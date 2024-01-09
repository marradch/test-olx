<?php

namespace Tests\Unit\Services;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Services\Subscriber;
use App\Models\Advert;
use App\Models\AdvertSubscriber;
use App\Exceptions\DuplicateSubscriberException;

class SubscriberTest extends TestCase
{
    use RefreshDatabase;

    public function testSubscribeNewAdvertAndSubscriber()
    {
        $subscriberService = new Subscriber();

        $url = 'https://example.com/advertisement';
        $email = 'subscriber@example.com';

        $subscriberService->subscribe($url, $email);

        $this->assertDatabaseHas('adverts', ['url' => $url]);
        $this->assertDatabaseHas('advert_subscribers', ['email' => $email]);
    }

    public function testSubscribeExistingAdvertAndNewSubscriber()
    {
        $advert = Advert::create(['url' => 'https://example.com/existing-advertisement']);

        $subscriberService = new Subscriber();

        $url = 'https://example.com/existing-advertisement';
        $email = 'newsubscriber@example.com';

        $subscriberService->subscribe($url, $email);

        $this->assertDatabaseHas('advert_subscribers', ['email' => $email, 'advert_id' => $advert->id]);
    }

    public function testSubscribeDuplicateSubscriber()
    {
        $this->expectException(DuplicateSubscriberException::class);

        $advert = Advert::create(['url' => 'https://example.com/duplicate-advertisement']);
        $email = 'duplicatesubscriber@example.com';

        AdvertSubscriber::create(['advert_id' => $advert->id, 'email' => $email]);

        $subscriberService = new Subscriber();

        $subscriberService->subscribe('https://example.com/duplicate-advertisement', $email);
    }
}
