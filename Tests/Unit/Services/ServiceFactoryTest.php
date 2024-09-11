<?php

namespace Tests\Unit\Services;

use App\Services\ServicesFactory;
use App\Services\Transactions\TransactionsManager;
use PHPUnit\Framework\TestCase;

class ServiceFactoryTest extends TestCase
{
    public function testCreateTransactionsManager()
    {
        $manager = ServicesFactory::createTransactionManager();
        $this->assertInstanceOf(TransactionsManager::class, $manager);
    }
}
