<?php

namespace Tests\Unit\Services;

use App\DataObjects\DataObjectFactory;
use App\DataObjects\Transaction;
use App\Services\TransactionsManager;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(TransactionsManager::class)]
class TransactionsManagerTest extends TestCase
{
    private const string VALID_INPUT_FILE = __DIR__ . '/test_data/test_data.txt';
    private const string INVALID_INPUT_FILE = __DIR__ . '/test_data/test_data_invalid.txt';

    private TransactionsManager $transactionsManager;

    public static function getTransactionsDataProvider(): array
    {
        return [
            ['inputFile' => self::VALID_INPUT_FILE],
            ['inputFile' => self::INVALID_INPUT_FILE],
        ];
    }

    #[DataProvider('getTransactionsDataProvider')]
    public function testGetTransactions(string $inputFile): void
    {
        $this->transactionsManager = new TransactionsManager(
            new DataObjectFactory(),
            $inputFile
        );

        $transactions = $this->transactionsManager->getTransactions();

        $this->assertContainsOnlyInstancesOf(Transaction::class, $transactions);

        if (self::VALID_INPUT_FILE == $inputFile) {
            $this->assertCount(5, $transactions);
        } else {
            $this->assertCount(2, $transactions);
        }
    }

    protected function tearDown(): void
    {
        unset($this->transactionsManager);
    }

}