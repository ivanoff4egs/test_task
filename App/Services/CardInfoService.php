<?php declare(strict_types = 1);

namespace App\Services;

use App\DataObjects\Card;
use App\DataObjects\DataObjectFactory;
use App\Enums\EUCountries;
use App\Exceptions\AppException;
use App\Providers\ProviderInterface;

class CardInfoService
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

        if (!isset($cardData['country']['alpha2'])) {
            throw new AppException("Missing required field 'country.alpha2'");
        }
        return $this->dataObjectFactory->createCard($cardData);
    }

    public function isEUCard(string $alpha2Country): bool
    {
        return in_array($alpha2Country, array_column(EUCountries::cases(), 'name'));
    }
}
