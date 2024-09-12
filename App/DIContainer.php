<?php declare(strict_types=1);

namespace App;

use App\DataObjects\DataObjectFactory;
use App\Services\TransactionsManager;

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
}