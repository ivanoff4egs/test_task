<?php declare(strict_types=1);

namespace App\Services;

use App\Config;
use App\DataObjects\CurrencyRate;
use App\DataObjects\DataObjectFactory;
use App\DataObjects\Transaction;
use App\Exceptions\AppException;

class TransactionsService
{
    function __construct(
        protected Config $config,
        protected DataObjectFactory $dataObjectFactory,
        protected string $inputFile
    ) {}

    /**
     * @throws AppException
     */
    public function getTransactions(): array
    {
        $transactions = [];

        $handler = fopen($this->inputFile, 'r');
        while ($line = fgets($handler)) {
            if (!json_validate($line)) {
                continue;
            }
            $transactionData = json_decode($line, true);
            $transaction = $this->dataObjectFactory->createTransaction($transactionData);
            $transactions[] = $transaction;
        }

        return $transactions;
    }

    /**
     * @throws AppException
     */
    public function calculateComission(
        CurrencyRate $currencyRate,
        Transaction $transaction,
        bool $isEuCard
    ): Transaction {
        $amount = $transaction->getAmount() / $currencyRate->getRate();
        $comission = $isEuCard ? $this->config->get('eu_cards_comission') : $this->config->get('non_eu_cards_comission');
        $comissionAmount = round($amount * $comission, 2);
        $transaction->setComission($comissionAmount);

        return $transaction;
    }
}