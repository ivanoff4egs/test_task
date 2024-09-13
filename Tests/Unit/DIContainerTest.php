<?php

namespace Tests\Unit;

use App\DIContainer;
use App\Services\TransactionsService;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DIContainer::class)]
class DIContainerTest extends TestCase
{
    public function testGetTransactionService()
    {
        $transactionManager = DIContainer::getInstance()->getTransactionService(
            __DIR__ . '/Services/test_data/test_data.txt'
        );

        $this->assertInstanceOf(TransactionsService::class, $transactionManager);
    }
}
