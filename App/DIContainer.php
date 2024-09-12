<?php declare(strict_types=1);

namespace App;

use App\Services\Http\RequestManager;
use App\Services\Transactions\TransactionsFactory;
use App\Services\Transactions\TransactionsManager;
use App\Services\Transactions\TransactionsProvider;
use GuzzleHttp\Client;

class DIContainer
{
    protected function __construct()
    {
        $this->services = [];
    }

    protected function __clone(){}

    private array $services;

    private static self $instance;

    public static function getInstance(): DIContainer
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getTransactionManager(AppConfig $appConfig): TransactionsManager
    {
        if (!array_key_exists(TransactionsManager::class, $this->services)) {
            $this->services[TransactionsManager::class] = new TransactionsManager(
                new TransactionsProvider(),
                new TransactionsFactory(),
                $appConfig
            );
        }

        return $this->services[TransactionsManager::class];
    }

    public function getRequestManager(AppConfig $appConfig): RequestManager
    {
        if (!array_key_exists(RequestManager::class, $this->services)) {
            $this->services[RequestManager::class] = new RequestManager(new Client(), $appConfig);
        }

        return $this->services[RequestManager::class];
    }
}