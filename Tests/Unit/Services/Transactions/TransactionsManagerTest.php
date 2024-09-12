<?php

namespace Tests\Unit\Services\Transactions;

use App\AppConfig;
use App\Services\Transactions\Transaction;
use App\Services\Transactions\TransactionsFactory;
use App\Services\Transactions\TransactionsManager;
use App\Services\Transactions\TransactionsProvider;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class TransactionsManagerTest extends TestCase
{
    private TransactionsManager $transactionsManager;

    private function getTestTransactions(): array
    {
        return [
            [
                "bin" => "45717360",
                "amount" => "100.00",
                "currency" => "EUR",
            ],
        ];
    }
    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $transactions = $this->getTestTransactions();
        $provider = $this->createMock(TransactionsProvider::class);
        $provider->method('getTransactions')->willReturn($transactions);
        $factory = new TransactionsFactory();
        $config = new AppConfig();

        $this->transactionsManager = new TransactionsManager($provider, $factory, $config);
    }

    public function testGetTransactions(): void
    {
        $transactions = $this->transactionsManager->getTransactions();
        $this->assertContainsOnlyInstancesOf(Transaction::class, $transactions);
    }

    protected function tearDown(): void
    {
        unset($this->transactionsManager);
    }

}
