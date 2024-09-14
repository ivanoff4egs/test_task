<?php

namespace Tests\Unit\Providers;

use App\Exceptions\AppException;
use App\Providers\BinlistCardInfoProvider;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(BinlistCardInfoProvider::class)]
class BinlistCardInfoProviderTest extends TestCase
{

    private static array | null $configData;

    private BinlistCardInfoProvider $provider;

    public static function setUpBeforeClass(): void
    {
        $appConfig = require __DIR__ . '/../test_config.php';
        self::$configData = $appConfig['card_info_providers']['binlist'];
    }

    public static function tearDownAfterClass(): void
    {
        self::$configData = null;
    }

    protected function tearDown(): void
    {
        unset($this->provider);
    }

    private function getClientMock(): Client
    {
        $client = $this->getMockBuilder(Client::class)->disableOriginalConstructor()->getMock();
        $response = $this->getMockBuilder(Response::class)->disableOriginalConstructor()->getMock();
        $responseBody = $this->getMockBuilder(Stream::class)->disableOriginalConstructor()->getMock();
        $responseBody->method('getContents')->willReturn(
            file_get_contents(__DIR__ . '/test_data/binlist_response.json')
        );
        $response->method('getBody')->willReturn($responseBody);
        $client->method('request')->willReturn($response);

        return $client;
    }

    private function getClientMockException(): Client
    {
        $client = $this->getMockBuilder(Client::class)->disableOriginalConstructor()->getMock();
        $client->method('request')->willThrowException(new TransferException());

        return $client;
    }

    public static function retrieveDataDataProvider(): array
    {
        return [
            ['bin'],
            ['']
        ];
    }

    #[DataProvider('retrieveDataDataProvider')]
    public function testRetrieveData(string $bin)
    {
        if (!$bin) {
            $this->expectException(AppException::class);
        }

        $this->provider = new BinlistCardInfoProvider($this->getClientMock(), self::$configData);
        $data = $this->provider->retrieveData($bin);

        $this->assertIsArray($data);
        $this->assertNotEmpty($data);
    }

    public function testGetDataException()
    {
        $this->expectException(AppException::class);
        $this->provider = new BinlistCardInfoProvider($this->getClientMockException(), self::$configData);
        $this->provider->retrieveData('test_bin');
    }
}
