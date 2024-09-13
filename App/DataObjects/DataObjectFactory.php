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


    public function createCard(array $fieldsMap, array $data): Card
    {
        $card = new Card();

        foreach ($fieldsMap as $cardProperty => $sourceProperty) {
            $value = $data;
            foreach (explode('.', $sourceProperty) as $key) {
                if (!isset($value[$key])) {
                    throw new AppException("Card field mapping error. `{$key}` not found in the response");
                }
                $value = $value[$key];
            }

            $method = 'set' . ucfirst($cardProperty);
            $card->$method($value);
        }

        return $card;
    }

}