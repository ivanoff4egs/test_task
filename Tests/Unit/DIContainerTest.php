<?php

namespace Tests\Unit;

use App\Services\TransactionsManager;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use App\DIContainer;

#[CoversClass(DIContainer::class)]
class DIContainerTest extends TestCase
{
    public function testGetTransactionManager()
    {
        $transactionManager = DIContainer::getInstance()->getTransactionManager(
            __DIR__ . '/Services/test_data/test_data.txt'
        );

        $this->assertInstanceOf(TransactionsManager::class, $transactionManager);
    }
}
