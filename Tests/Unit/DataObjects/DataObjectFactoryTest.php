<?php

namespace Tests\Unit\DataObjects;

use App\DataObjects\DataObjectFactory;
use App\DataObjects\Transaction;
use App\Exceptions\AppException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(DataObjectFactory::class)]
class DataObjectFactoryTest extends TestCase
{

    protected function setUp(): void
    {
        $this->factory = new DataObjectFactory();
    }

    private const array VALID_TRANSACTION_DATA = [
        "bin" => "45717360",
        "amount" => "100.00",
        "currency" => "EUR",
    ];

    private const array INVALID_TRANSACTION_DATA = [];

    public static function createTransactionDataProvider(): array
    {
        return [
            [self::VALID_TRANSACTION_DATA],
            [self::INVALID_TRANSACTION_DATA]
        ];
    }

    #[DataProvider('createTransactionDataProvider')]
    public function testCreateTransaction(array $data): void
    {
        if ($data == self::VALID_TRANSACTION_DATA) {
            $transaction = $this->factory->createTransaction(self::VALID_TRANSACTION_DATA);

            $this->assertInstanceOf(Transaction::class, $transaction);
            $this->assertNotEmpty($transaction->getBin());
            $this->assertNotEmpty($transaction->getAmount());
            $this->assertNotEmpty($transaction->getCurrency());
        } else {
            try {
                $this->factory->createTransaction(self::INVALID_TRANSACTION_DATA);
                $this->fail("Expected Exception not thrown");
            } catch (\Exception $e) {
                $this->assertInstanceOf(AppException::class, $e);
            }
        }
    }
}
