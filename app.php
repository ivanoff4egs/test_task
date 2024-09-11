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

$AppConfig = App\Config\ConfigFactory::createAppConfig();
$AppConfig->setConfigValue('inputFile', $inputFile);

try {
    $transactionsManager = App\Services\ServicesFactory::createTransactionManager();
    $transactions = $transactionsManager->getTransactions();
} catch (\App\Exceptions\AppException $e) {
    print $e->getMessage();
    exit();
}


