<?php

namespace App\Services;

use GuzzleHttp\Client;

class PriceDetector
{
    public function __construct(
        protected Client $httpClient,
    ) {}

    public function getPriceByUrl($url) : float
    {
        $response = $this->httpClient->get($url);
        $body = $response->getBody()->getContents();

        return $this->extractPriceFromBody($body);
    }

    protected function extractPriceFromBody($body) : float
    {
        $matches = [];
        if (preg_match('/regularPrice(.*?),/s', $body, $matches)) {
            $matches2 = [];
            if (preg_match('/\d+$/', $matches[1], $matches2)) {
                return (float) $matches2[0];
            }
        }

        throw new \Exception('Can not find price in page body');
    }
}
