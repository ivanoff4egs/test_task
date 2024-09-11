<?php

namespace Tests\Unit\Services;

use App\Config\AppConfigFactory;
use App\Services\ServicesFactory;
use App\Services\Transactions\TransactionsManager;
use PHPUnit\Framework\TestCase;

class ServiceFactoryTest extends TestCase
{
    public function testCreateTransactionsManager(): void
    {
        $manager = ServicesFactory::createTransactionManager(AppConfigFactory::createAppConfig());
        $this->assertInstanceOf(TransactionsManager::class, $manager);
    }
}
