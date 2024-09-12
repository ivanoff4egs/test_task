<?php

namespace Tests\Unit\Services\Transactions;

use App\AppConfig;
use App\Exceptions\AppException;
use App\Services\Transactions\TransactionsProvider;
use PHPUnit\Framework\TestCase;

class TransactionsProviderTest extends TestCase
{
    private TransactionsProvider $transactionsProvider;

    protected function setUp(): void
    {
        $this->transactionsProvider = new TransactionsProvider();
    }

    public function testGetTransactions(): void
    {
        $config = new AppConfig(['inputFile' => __DIR__ . '/test_data/test_data.txt']);

        $transactions = $this->transactionsProvider->getTransactions($config);
        $this->assertIsArray($transactions);
        $this->assertCount(5, $transactions);
    }

    public function testGetTransactionsFileNotSet(): void
    {
        $config = new AppConfig();
        try {
            $this->transactionsProvider->getTransactions($config);
            $this->fail("Expected AppException not thrown");
        } catch (\Exception $e) {
            $this->assertInstanceOf(AppException::class, $e);
        }
    }

    public function testGetTransactionsInvalidLine(): void
    {
        $config = new AppConfig(['inputFile' => __DIR__ . '/test_data/test_data_invalid_json.txt']);

        $transactions = $this->transactionsProvider->getTransactions($config);
        $this->assertCount(2, $transactions);
    }

    protected function tearDown(): void
    {
        unset($this->transactionsProvider);
    }
}
