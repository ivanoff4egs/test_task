<?php

namespace Tests\Unit\Services;

use App\DataObjects\DataObjectFactory;
use App\Services\RatesService;
use PHPUnit\Framework\TestCase;

class RatesServiceTest extends TestCase
{
    private RatesService $service;

    protected function setUp(): void
    {
        $provider = $this->getMockBuilder(RatesService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $provider
            ->method('retrieveData')
            ->willReturn(
                json_decode(
                    file_get_contents(__DIR__ . 'test_data/rates.json'), true
                )
            );

        $this->service = new RatesService($provider, new DataObjectFactory());
    }

    protected function tearDown(): void
    {
        unset($this->service);
    }
}
