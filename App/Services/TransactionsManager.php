<?php declare(strict_types=1);

namespace App\Services;

use App\DataObjects\DataObjectFactory;

class TransactionsManager
{
    function __construct(
        protected DataObjectFactory $dataObjectFactory,
        protected string $inputFile
    ) {}

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
}