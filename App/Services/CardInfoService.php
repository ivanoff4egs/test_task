<?php

namespace App\Services;

use App\DataObjects\Card;
use App\DataObjects\DataObjectFactory;
use App\Enums\EUCountries;
use App\Exceptions\AppException;
use App\Providers\ProviderInterface;

readonly class CardInfoService
{
    public function __construct(
        private ProviderInterface $provider,
        private DataObjectFactory $dataObjectFactory,
    ) {}

    /**
     * @throws AppException
     */
    public function getCardInfo(string $bin): Card
    {
        $cardData = $this->provider->retrieveData($bin);

        return $this->dataObjectFactory->createCard($this->provider->getFieldsMap(), $cardData);
    }

    public function isEUCard(string $alpha2Country): bool
    {
        var_dump($alpha2Country);
        var_dump(EUCountries::cases());

        return in_array($alpha2Country, array_column(EUCountries::cases(), 'name'));
    }
}