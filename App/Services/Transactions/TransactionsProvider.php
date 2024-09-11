<?php

namespace App\Services\Transactions;

use App\Config\ConfigFactory;
use App\Exceptions\AppException;
use RuntimeException;

class TransactionsProvider implements TransactionsProviderInterface
{
    public function getTransactions(): array
    {
        $inputFile = ConfigFactory::createAppConfig()->getConfigValue('inputFile');
        if (!$inputFile) {
            throw new AppException('Input file not set');
        }

        $transactions = [];
        $handler = fopen($inputFile, 'r');
        while ($line = fgets($handler)) {
            if (!is_string($line) && !json_validate($line)) {
                throw new AppException('Invalid input');
            }
            $transactions[] = json_decode($line, true);
        }

        return $transactions;
    }
}