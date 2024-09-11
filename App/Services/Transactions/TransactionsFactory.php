<?php
declare(strict_types=1);

namespace App\Services\Transactions;

use App\Exceptions\AppException;

class TransactionsFactory
{
    private array $requiredFields;

    public function __construct()
    {
        $this->requiredFields = [
            'bin',
            'amount',
            'currency',
        ];
    }

    public function createTransaction(array $data): Transaction {

        foreach ($this->requiredFields as $field) {
            if (!array_key_exists($field, $data)) {
                throw new AppException("Missing required field '$field' in line %s");
            }
        }

        $transaction = new Transaction();
        $transaction->setBin($data['bin']);
        $transaction->setAmount(floatval($data['amount']));
        $transaction->setCurrency($data['currency']);

        return $transaction;
    }
}