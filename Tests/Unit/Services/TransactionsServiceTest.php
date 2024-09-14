<?php

namespace Tests\Unit\Services;

use App\Config;
use App\DataObjects\Comission;
use App\DataObjects\CurrencyRate;
use App\DataObjects\DataObjectFactory;
use App\DataObjects\Transaction;
use App\Exceptions\AppException;
use App\Services\TransactionsService;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(TransactionsService::class)]
class TransactionsServiceTest extends TestCase
{
    private const string VALID_INPUT_FILE = __DIR__ . '/../test_data/test_data.txt';
    private const string INVALID_INPUT_FILE = __DIR__ . '/../test_data/test_data_invalid.txt';

    private TransactionsService $transactionsService;

    public static function getTransactionsDataProvider(): array
    {
        return [
            ['inputFile' => self::VALID_INPUT_FILE],
            ['inputFile' => self::INVALID_INPUT_FILE],
        ];
    }

    /**
     * @throws AppException
     */
    #[DataProvider('getTransactionsDataProvider')]
    public function testGetTransactions(string $inputFile): void
    {

        $this->transactionsService = new TransactionsService(
            new Config([]),
            new DataObjectFactory(),
            $inputFile
        );

        $transactions = $this->transactionsService->getTransactions();

        $this->assertContainsOnlyInstancesOf(Transaction::class, $transactions);

        if (self::VALID_INPUT_FILE == $inputFile) {
            $this->assertCount(5, $transactions);
        } else {
            $this->assertCount(2, $transactions);
        }
    }

    public static function calculateComissionDataProvider(): array
    {
        return [
            [true],
            [false],
        ];
    }

    #[DataProvider('calculateComissionDataProvider')]
    public function testCalculateComission(bool $isEuCard)
    {
        $this->transactionsService = new TransactionsService(
            new Config(require __DIR__ . '/../test_config.php'),
            new DataObjectFactory(),
            ''
        );

        $rate = new CurrencyRate();
        $rate->setRate(1.1);

        $transaction = new Transaction();
        $transaction->setAmount(100);

        $transaction = $this->transactionsService->calculateComission($rate, $transaction, $isEuCard);
        $this->assertInstanceOf(Comission::class, $transaction->getComission());
        $comission = $transaction->getComission();
        $isEuCard
            ? $this->assertEquals(0.91, $comission->getAmount())
            : $this->assertEquals(1.82, $comission->getAmount());
    }

    protected function tearDown(): void
    {
        unset($this->transactionsManager);
    }
}
