<?php

namespace Tests\Unit\Services\Transactions;

use App\Exceptions\AppException;
use App\Services\Transactions\Transaction;
use App\Services\Transactions\TransactionsFactory;
use PHPUnit\Framework\TestCase;

class TransactionsFactoryTest extends TestCase
{
    private const array VALID_TRANSACTION_DATA = [
        "bin" => "45717360",
        "amount" => "100.00",
        "currency" => "EUR",
    ];

    private const array INVALID_TRANSACTION_DATA = [];

    public TransactionsFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new TransactionsFactory();
    }

    public function testCreateTransaction()
    {
        $transaction = $this->factory->createTransaction(self::VALID_TRANSACTION_DATA);

        $this->assertInstanceOf(Transaction::class, $transaction);
        $this->assertNotEmpty($transaction->getBin());
        $this->assertNotEmpty($transaction->getAmount());
        $this->assertNotEmpty($transaction->getCurrency());
    }

    public function testCreateTransactionNegative()
    {
        try {
            $this->factory->createTransaction(self::INVALID_TRANSACTION_DATA);
        } catch (\Exception $e) {
            $this->assertInstanceOf(AppException::class, $e);
        }
    }

    protected function tearDown(): void
    {
        unset($this->factory);
    }
}
