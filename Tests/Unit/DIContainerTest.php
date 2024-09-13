<?php

namespace Tests\Unit;

use App\Config;
use App\DIContainer;
use App\Exceptions\AppException;
use App\Services\CardInfoService;
use App\Services\RatesService;
use App\Services\TransactionsService;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DIContainer::class)]
class DIContainerTest extends TestCase
{
    private DIContainer $container;

    private static array | null $configData;

    public static function setUpBeforeClass(): void
    {
        self::$configData = require 'test_config.php';
    }

    public static function tearDownAfterClass(): void
    {
        self::$configData = null;
    }

    protected function setUp(): void
    {
        $this->container = DIContainer::getInstance();
        $this->config = new Config(self::$configData);
    }

    protected function tearDown(): void
    {
        unset($this->container);
        unset($this->config);
    }

    public function testGetTransactionService()
    {
        $transactionService = $this->container->getTransactionsService(
            $this->config,
            __DIR__ . '/Services/test_data/test_data.txt'
        );

        $this->assertInstanceOf(TransactionsService::class, $transactionService);
    }

    /**
     * @throws AppException
     */
    public function testGetCardInfoService()
    {
        $cardInfoService = $this->container->getCardInfoService($this->config);

        $this->assertInstanceOf(CardInfoService::class, $cardInfoService);
    }

    /**
     * @throws AppException
     */
    public function testGetRatesService()
    {
        $ratesService = $this->container->getRatesService($this->config);

        $this->assertInstanceOf(RatesService::class, $ratesService);
    }
}
