<?php

namespace App\Services\Transactions;

use App\Exceptions\AppException;

class TransactionsManager
{
    function __construct(
        public TransactionsProvider $transactionsProvider,
        public TransactionsFactory $transactionsFactory
    ) {}


    /**
     * @throws AppException
     */
    public function getTransactions(): array
    {
        $transactions = [];
        $transactionsData = $this->transactionsProvider->getTransactions();
        foreach ($transactionsData as $transactionData) {
            $transaction = $this->transactionsFactory->createTransaction($transactionData);
            $transactions[] = $transaction;
        }

        return $transactions;
    }
}