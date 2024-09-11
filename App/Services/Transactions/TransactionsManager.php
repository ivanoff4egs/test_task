<?php
declare(strict_types=1);

namespace App\Services\Transactions;

use App\Config\AppConfig;
use App\Exceptions\AppException;

class TransactionsManager
{
    function __construct(
        protected TransactionsProvider $transactionsProvider,
        protected TransactionsFactory $transactionsFactory,
        protected AppConfig $appConfig
    ) {}


    /**
     * @throws AppException
     */
    public function getTransactions(): array
    {
        $transactions = [];
        $transactionsData = $this->transactionsProvider->getTransactions($this->appConfig);
        foreach ($transactionsData as $transactionData) {
            $transaction = $this->transactionsFactory->createTransaction($transactionData);
            $transactions[] = $transaction;
        }

        return $transactions;
    }
}