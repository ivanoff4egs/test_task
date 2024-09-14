<?php

namespace Tests\Unit\Services;

use App\DataObjects\CurrencyRate;
use App\DataObjects\DataObjectFactory;
use App\Exceptions\AppException;
use App\Providers\ExchangeratesRatesProvider;
use App\Services\RatesService;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(RatesService::class)]
class RatesServiceTest extends TestCase
{
    private RatesService $service;


    private function getService(array $providerResponse): RatesService
    {
        $provider = $this->getMockBuilder(ExchangeratesRatesProvider::class)
            ->disableOriginalConstructor()
            ->getMock();

        $provider
            ->method('retrieveData')
            ->willReturn($providerResponse);

        return new RatesService($provider, new DataObjectFactory());
    }

    private static function getProviderResponse(): array
    {
        return json_decode(
            file_get_contents(
                __DIR__ . '/../test_data/exchangerates_response.json',
                true
            ),
            true
        );
    }

    public static function getRatesDataProvider(): array
    {
        $providerResponse = self::getProviderResponse();

        return [
            [$providerResponse],
            [[]]
        ];
    }

    #[DataProvider('getRatesDataProvider')]
    public function testGetRates($providerResponse)
    {
        if (empty($providerResponse)) {
            $this->expectException(AppException::class);
        }

        $service = $this->getService($providerResponse);
        $rates = $service->getRates();

        $this->assertIsArray($rates);
    }

    public static function getRateDataProvider(): array
    {
        return [
            ['USD'],
            ['unknown']
        ];
    }

    #[DataProvider('getRateDataProvider')]
    public function testGetRate(string $currency)
    {
        if ('unknown' === $currency) {
            $this->expectException(AppException::class);
        }

        $service = $this->getService(self::getProviderResponse());
        $service->getRates();
        $rate = $service->getRate($currency);

        $this->assertInstanceOf(CurrencyRate::class, $rate);
    }
}
