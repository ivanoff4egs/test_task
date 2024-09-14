<?php

namespace Tests\Unit\Services;

use App\DataObjects\Card;
use App\DataObjects\DataObjectFactory;
use App\Providers\BinlistCardInfoProvider;
use App\Services\CardInfoService;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(CardInfoService::class)]
class CardInfoServiceTest extends TestCase
{

    private CardInfoService $cardInfoService;

    protected function setUp(): void
    {
        $provider = $this->getMockBuilder(BinlistCardInfoProvider::class)
            ->disableOriginalConstructor()
            ->getMock();
        $provider->method('retrieveData')->willReturn(require 'test_data/binlist_response.php');
        $this->cardInfoService = new CardInfoService(
            $provider,
            new DataObjectFactory(),
        );
    }

    protected function tearDown(): void
    {
        unset($this->cardInfoService);
    }

    public function testGetCardInfo()
    {
        $card = $this->cardInfoService->getCardInfo('bin');
        $this->assertInstanceOf(Card::class, $card);
    }

    public static function isEUCardDataProvider(): array
    {
        $euCard = $nonEuCard = new Card();
        $euCard->setCountry('DE');
        $nonEuCard->setCountry('JP');


        return [
            [$euCard],
            [$nonEuCard],
        ];
    }

    #[DataProvider('isEUCardDataProvider')]
    public function testIsEUCard(Card $card): void
    {
        $result = $this->cardInfoService->isEUCard($card);

        $card->getCountry() === 'JP' ? $this->assertFalse($result) : $this->assertTrue($result);
    }
}
