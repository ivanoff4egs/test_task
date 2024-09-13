<?php

namespace App\Services;

use App\DataObjects\Card;
use App\DataObjects\DataObjectFactory;
use App\Enums\EUCountries;
use App\Exceptions\AppException;
use App\Providers\ProviderInterface;

readonly class CardInfoManager
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
        return in_array($alpha2Country, EUCountries::cases());
    }
}