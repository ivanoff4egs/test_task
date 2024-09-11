<?php declare(strict_types=1);

namespace App\Services\Transactions;

use App\Config\AppConfig;

interface TransactionsProviderInterface
{
    public function getTransactions(AppConfig $config): array;
}