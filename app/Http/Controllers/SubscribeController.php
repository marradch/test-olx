<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscribeRequest;
use App\Services\Subscriber;
use Illuminate\Http\JsonResponse;

class SubscribeController extends Controller
{
    public function subscribe(SubscribeRequest $request): JsonResponse
    {
        (new Subscriber())->subscribe($request->url, $request->email);

        return (new JsonResponse(['status' => 'success']));
    }
}
