<?php declare(strict_types=1);

namespace App;

use App\DataObjects\DataObjectFactory;
use App\Exceptions\AppException;
use App\Providers\ProviderFactory;
use App\Services\CardInfoManager;
use App\Services\TransactionsManager;
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

    public function getTransactionManager(string $inputFile): TransactionsManager
    {
        if (!array_key_exists(TransactionsManager::class, $this->services)) {
            $this->services[TransactionsManager::class] = new TransactionsManager(
                new DataObjectFactory(),
                $inputFile
            );
        }

        return $this->services[TransactionsManager::class];
    }

    /**
     * @throws AppException
     */
    public function getCardInfoManager(Config $config): CardInfoManager
    {
        if (!array_key_exists(CardInfoManager::class, $this->services)) {
            $provider = $config->get('default_card_info_provider');
            $providerConfigs = $config->get('card_info_providers');
            $providerConfig = $providerConfigs[$provider];
            $client =
            $provider = (new ProviderFactory())->createCardInfoProvider(
                $this->getHttpClient(),
                $providerConfig
            );

            $this->services[CardInfoManager::class] = new CardInfoManager(
                $provider,
                new DataObjectFactory()
            );
        }

        return $this->services[CardInfoManager::class];
    }
}