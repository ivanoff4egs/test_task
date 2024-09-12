<?php
require_once 'vendor/autoload.php';

if (!isset($argv[1])) {
    print("Input file is required\n");
    exit();
}

$inputFile = $argv[1];

if (!file_exists($inputFile)) {
    printf("File %s does not exist\n", $inputFile);
    exit();
}

try {
    $transactionsManager = \App\DIContainer::getInstance()->getTransactionManager($inputFile);
    $transactions = $transactionsManager->getTransactions();
} catch (\App\Exceptions\AppException $e) {
    print $e->getMessage();
    exit();
}

//foreach ($transactions as $transaction) {
//
//}


