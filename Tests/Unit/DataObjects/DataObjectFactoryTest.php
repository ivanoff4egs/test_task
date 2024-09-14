<?php

namespace Tests\Unit\DataObjects;

use App\DataObjects\Card;
use App\DataObjects\Comission;
use App\DataObjects\CurrencyRate;
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
            [self::VALID_TRANSACTION_DATA, true],
            [self::INVALID_TRANSACTION_DATA, false]
        ];
    }

    #[DataProvider('createTransactionDataProvider')]
    public function testCreateTransaction(array $data, bool $expectedResult): void
    {
        if (!$expectedResult) {
            $this->expectException(AppException::class);
        }
        $transaction = $this->factory->createTransaction($data);

        $this->assertInstanceOf(Transaction::class, $transaction);
        $this->assertNotEmpty($transaction->getBin());
        $this->assertNotEmpty($transaction->getAmount());
        $this->assertNotEmpty($transaction->getCurrency());
    }

    public function testCreateCard()
    {
        $card = $this->factory->createCard(['country' => ['alpha2' => 'DK']]);
        $this->assertInstanceOf(Card::class, $card);
        $this->assertNotEmpty($card->getCountry());
    }

    public function testCreateCurrencyRate()
    {
        $rate = $this->factory->createCurrencyRate('USD', 1.1);
        $this->assertInstanceOf(CurrencyRate::class, $rate);
        $this->assertNotEmpty($rate->getCurrencyTo());
        $this->assertNotEmpty($rate->getRate());
    }

    public function testCreateComission()
    {
        $comission = $this->factory->createComission('EUR', 1.2);
        $this->assertInstanceOf(Comission::class, $comission);
        $this->assertNotEmpty($comission->getAmount());
        $this->assertNotEmpty($comission->getCurrency());
    }
}
