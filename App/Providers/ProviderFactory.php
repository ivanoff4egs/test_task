<?php declare(strict_types=1);

namespace App\Providers;

use GuzzleHttp\Client;

class ProviderFactory
{
    public function createCardInfoProvider(Client $client, array $providerConfig): ProviderInterface
    {
        $class = $providerConfig['class'];

        return new $class($client, $providerConfig);
    }
}