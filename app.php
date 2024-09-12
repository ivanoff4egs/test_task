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

$appConfig = new \App\AppConfig(['inputFile' => $inputFile]);

try {
    $transactionsManager = \App\DIContainer::getInstance()->getTransactionManager($appConfig);
    $transactions = $transactionsManager->getTransactions();
    var_dump($transactions);
} catch (\App\Exceptions\AppException $e) {
    print $e->getMessage();
    exit();
}


