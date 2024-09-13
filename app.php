<?php

use App\Config;
use App\DataObjects\Transaction;
use App\DIContainer;
use App\Exceptions\AppException;

require_once 'vendor/autoload.php';

if (!isset($argv[1])) {
    print("Input file is required\r\n");
    exit();
}

$inputFile = $argv[1];

if (!file_exists($inputFile)) {
    printf("File %s does not exist\n", $inputFile);
    exit();
}

$configData = require_once(Config::CONFIG_FILE);
$config = new Config($configData);

try {
    $transactionsManager = DIContainer::getInstance()->getTransactionManager($inputFile);
    $cardInfoManager = DIContainer::getInstance()->getCardInfoManager($config);

    $transactions = $transactionsManager->getTransactions();

    /**
     * @var Transaction $transaction
     */
    foreach ($transactions as $transaction) {
            $card = $cardInfoManager->getCardInfo($transaction->getBin());
            var_dump($card);
            die();
    }


} catch (AppException $e) {
    print ($e->getMessage() . PHP_EOL);
    exit();
}


