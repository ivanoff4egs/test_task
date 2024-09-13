<?php

namespace Tests\Unit;

use App\Config;
use App\DIContainer;
use App\Services\TransactionsService;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DIContainer::class)]
class DIContainerTest extends TestCase
{
    public function testGetTransactionService()
    {
        $configData = require_once "test_config.php";
        $config = new Config($configData);
        $transactionManager = DIContainer::getInstance()->getTransactionService(
            $config,
            __DIR__ . '/Services/test_data/test_data.txt'
        );

        $this->assertInstanceOf(TransactionsService::class, $transactionManager);
    }
}
