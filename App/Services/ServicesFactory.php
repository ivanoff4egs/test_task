<?php

namespace App\Services;

use App\Services\Transactions\TransactionsFactory;
use App\Services\Transactions\TransactionsManager;
use App\Services\Transactions\TransactionsProvider;

class ServicesFactory
{
    public static function createTransactionManager(): TransactionsManager
    {
        return new TransactionsManager(new TransactionsProvider(), new TransactionsFactory());
    }
}