<?php declare(strict_types=1);

namespace App\Providers;

use App\Exceptions\AppException;
use GuzzleHttp\Client;

class ProviderFactory
{
    public function createProvider(Client $client, array $providerConfig): ProviderInterface
    {
        $class = $providerConfig['class'] ?? '';

        if (class_exists($class)) {
            return new $class($client, $providerConfig);
        }

        throw new AppException("Provider class {$class} not found");
    }
}
