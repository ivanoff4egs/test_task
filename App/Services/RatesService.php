<?php declare(strict_types = 1);

namespace App\Services;

use App\DataObjects\CurrencyRate;
use App\DataObjects\DataObjectFactory;
use App\Exceptions\AppException;
use App\Providers\ProviderInterface;

class RatesService
{
    private array $rates;

    /**
     * @throws AppException
     */
    public function __construct(
        private readonly ProviderInterface $provider,
        private readonly DataObjectFactory $dataObjectFactory,
    ) {
        $this->rates = $this->getRates();
    }

    /**
     * @throws AppException
     */
    private function getRates(): array
    {
        $ratesData = $this->provider->retrieveData();
        if (!isset($ratesData['rates'])) {
            throw new AppException("Missing required field 'rates'");
        }

        return $ratesData['rates'];
    }

    /**
     * @throws AppException
     */
    public function getRate($currency): CurrencyRate
    {
        $rateValue = $this->rates[$currency] ?? null;
        if (!$rateValue) {
            throw new AppException("Unknown currency '$currency'");
        }

        return $this->dataObjectFactory->createCurrencyRate($currency, $rateValue);
    }
}
