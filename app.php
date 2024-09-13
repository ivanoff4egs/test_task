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
    $transactionsManager = DIContainer::getInstance()->getTransactionService($inputFile);
    $cardInfoManager = DIContainer::getInstance()->getCardInfoService($config);

    $transactions = $transactionsManager->getTransactions();

    /**
     * @var Transaction $transaction
     */
    foreach ($transactions as $transaction) {
            $card = $cardInfoManager->getCardInfo($transaction->getBin());
            $isEUCard = $cardInfoManager->isEUCard($card->getCountry());
            var_dump($card);
            var_dump($isEUCard);
            die();
    }


} catch (AppException $e) {
    print ($e->getMessage() . PHP_EOL);
    exit();
}


