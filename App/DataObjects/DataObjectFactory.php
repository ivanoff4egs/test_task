<?php declare(strict_types=1);

namespace App\DataObjects;

use App\Exceptions\AppException;

class DataObjectFactory
{
    /**
     * @throws AppException
     */
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


    public function createCard(array $data): Card
    {
        $card = new Card();
        $card->setCountry($data['country']['alpha2']);

        return $card;
    }

    public function createCurrencyRate(string $to, float $rate): CurrencyRate
    {
        $currencyRate = new CurrencyRate();
        $currencyRate->setCurrencyTo($to);
        $currencyRate->setRate($rate);

        return $currencyRate;
    }

    public function createComission(string $currency, float $amount): Comission
    {
        $comission = new Comission();
        $comission->setCurrency($currency);
        $comission->setAmount($amount);

        return $comission;
    }

}