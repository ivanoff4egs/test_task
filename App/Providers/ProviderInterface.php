<?php declare(strict_types = 1);

namespace App\Providers;

interface ProviderInterface
{
    public function retrieveData(string $path = ''): array;
}
