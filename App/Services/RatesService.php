<?php declare(strict_types = 1);

namespace App\Services;

use App\DataObjects\CurrencyRate;
use App\DataObjects\DataObjectFactory;
use App\Exceptions\AppException;
use App\Providers\ProviderInterface;

class RatesService
{
    private array $rates;

    public function __construct(
        private readonly ProviderInterface $provider,
        private readonly DataObjectFactory $dataObjectFactory,
    ) {}

    /**
     * @throws AppException
     */
    public function getRates(): array
    {
        $ratesData = $this->provider->retrieveData();
        if (!isset($ratesData['rates'])) {
            throw new AppException("Missing required field 'rates'");
        }
        $this->rates = $ratesData['rates'];

        return $this->rates;
    }

    /**
     * @throws AppException
     */
    public function getRate(string $currency): CurrencyRate
    {
        $rateValue = $this->rates[$currency] ?? null;
        if (!$rateValue) {
            throw new AppException("Unknown currency '$currency'");
        }

        return $this->dataObjectFactory->createCurrencyRate($currency, $rateValue);
    }
}
