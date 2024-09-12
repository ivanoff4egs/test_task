<?php declare(strict_types=1);

namespace App\DataObjects;

use App\Exceptions\AppException;

class DataObjectFactory
{
    public function createTransaction(array $data): Transaction
    {
        $requiredFields = [
            'bin',
            'amount',
            'currency',
        ];

        $transaction = new Transaction();
        foreach ($requiredFields as $field) {
            if (!array_key_exists($field, $data)) {
                throw new AppException("Missing required field '$field' in line %s");
            }
        }

        $transaction->setBin($data['bin']);
        $transaction->setAmount(floatval($data['amount']));
        $transaction->setCurrency($data['currency']);

        return $transaction;
    }
}