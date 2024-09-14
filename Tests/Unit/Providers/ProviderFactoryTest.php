<?php

namespace Tests\Unit\Providers;

use App\Exceptions\AppException;
use App\Providers\BinlistCardInfoProvider;
use App\Providers\ProviderFactory;
use GuzzleHttp\Client;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ProviderFactory::class)]
class ProviderFactoryTest extends TestCase
{

    private ProviderFactory $providerFactory;

    protected function setUp(): void
    {
        $this->providerFactory = new ProviderFactory();
    }

    protected function tearDown(): void
    {
        unset($this->providerFactory);
    }

    public static function createProviderDataProvider(): array
    {
        return [
            [['class' => BinlistCardInfoProvider::class], true],
            [['class' => 'UnknownClass'], false],
            [[], false],
        ];
    }

    #[DataProvider('createProviderDataProvider')]
    public function testCreateProvider(array $providerConfig, bool $expectedResult)
    {
        if (!$expectedResult) {
            $this->expectException(AppException::class);
        }

        $provider = $this->providerFactory->createProvider(
            $this->getMockBuilder(Client::class)->disableOriginalConstructor()->getMock(),
            $providerConfig
        );

        $this->assertInstanceOf(BinlistCardInfoProvider::class, $provider);
    }
}
