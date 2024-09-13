<?php declare(strict_types=1);

namespace App;

use App\DataObjects\DataObjectFactory;
use App\Exceptions\AppException;
use App\Providers\ProviderFactory;
use App\Services\CardInfoService;
use App\Services\RatesService;
use App\Services\TransactionsService;
use GuzzleHttp\Client;

class DIContainer
{
    private array $services;

    private static self $instance;

    protected function __construct()
    {
        $this->services = [];
    }

    protected function __clone() {}

    public static function getInstance(): DIContainer
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getHttpClient(): Client
    {
        if (!isset($this->services[Client::class])) {
            $this->services[Client::class] = new Client();
        }

        return $this->services[Client::class];
    }

    public function getTransactionsService(Config $config, string $inputFile): TransactionsService
    {
        if (!array_key_exists(TransactionsService::class, $this->services)) {
            $this->services[TransactionsService::class] = new TransactionsService(
                $config,
                new DataObjectFactory(),
                $inputFile
            );
        }

        return $this->services[TransactionsService::class];
    }

    /**
     * @throws AppException
     */
    public function getCardInfoService(Config $config): CardInfoService
    {
        if (!array_key_exists(CardInfoService::class, $this->services)) {
            $provider = $config->get('default_card_info_provider');
            $providerConfigs = $config->get('card_info_providers');
            $providerConfig = $providerConfigs[$provider];
            $provider = (new ProviderFactory())->createProvider(
                $this->getHttpClient(),
                $providerConfig
            );

            $this->services[CardInfoService::class] = new CardInfoService($provider, new DataObjectFactory());
        }

        return $this->services[CardInfoService::class];
    }

    /**
     * @throws AppException
     */
    public function getRatesService(Config $config): RatesService
    {
        if (!isset($this->services[RatesService::class])) {
            $provider = $config->get('default_rates_provider');
            $providerConfigs = $config->get('rates_providers');
            $providerConfig = $providerConfigs[$provider];
            $provider = (new ProviderFactory())->createProvider(
                $this->getHttpClient(),
                $providerConfig
            );

            $this->services[RatesService::class] = new RatesService($provider, new DataObjectFactory());
        }

        return $this->services[RatesService::class];
    }
}
