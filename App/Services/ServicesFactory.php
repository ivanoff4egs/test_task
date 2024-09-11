<?php declare(strict_types=1);

namespace App\Services;

use App\Config\AppConfig;
use App\Services\Transactions\TransactionsFactory;
use App\Services\Transactions\TransactionsManager;
use App\Services\Transactions\TransactionsProvider;

class ServicesFactory
{
    public static function createTransactionManager(AppConfig $appConfig): TransactionsManager
    {
        return new TransactionsManager(new TransactionsProvider(), new TransactionsFactory(), $appConfig);
    }
}