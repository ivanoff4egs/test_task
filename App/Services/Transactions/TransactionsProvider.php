<?php declare(strict_types=1);

namespace App\Services\Transactions;

use App\AppConfig;
use App\Exceptions\AppException;

class TransactionsProvider implements TransactionsProviderInterface
{

    /**
     * @throws AppException
     */
    private function getInputFile(AppConfig $appConfig)
    {
        $inputFile = $appConfig->getConfigValue('inputFile');

        if (!$inputFile) {
            throw new AppException('Input file not set');
        }

        return $inputFile;
    }

    /**
     * @throws AppException
     */
    public function getTransactions(AppConfig $config): array
    {
        $inputFile = $this->getInputFile($config);
        $transactions = [];
        $handler = fopen($inputFile, 'r');
        while ($line = fgets($handler)) {
            if (!json_validate($line)) {
                continue;
            }
            $transactions[] = json_decode($line, true);
        }

        return $transactions;
    }
}