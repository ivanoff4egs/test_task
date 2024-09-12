<?php

namespace App\Services\Http;

use App\AppConfig;
use GuzzleHttp\Client;

class RequestManager
{
    public function __construct(Client $client, AppConfig $appConfig) {}
}