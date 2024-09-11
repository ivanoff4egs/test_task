<?php

namespace App\Services\Transactions;

use App\Exceptions\AppException;

class TransactionsFactory
{
    private array $requiredFields = [
        'bin',
        'amount',
        'currency',
    ];

    public function createTransaction(array $data): Transaction {

        foreach ($this->requiredFields as $field) {
            if (!isset($data[$field])) {
                throw new AppException("Missing required field '$field' in line %s");
            }
        }

        $transaction = new Transaction();
        $transaction->setBin($data['bin']);
        $transaction->setAmount($data['amount']);
        $transaction->setCurrency($data['currency']);

        return $transaction;
    }
}