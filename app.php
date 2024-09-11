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

$appConfig = App\Config\ConfigFactory::createAppConfig();
$appConfig->setConfigValue('inputFile', $inputFile);

try {
    $transactionsManager = App\Services\ServicesFactory::createTransactionManager($appConfig);
    $transactions = $transactionsManager->getTransactions();
    var_dump($transactions);
} catch (\App\Exceptions\AppException $e) {
    print $e->getMessage();
    exit();
}


