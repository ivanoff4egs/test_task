<?php declare(strict_types=1);

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

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

try {
    $dotenv->required('EXCHANGERATES_ACCESS_KEY');
} catch (RuntimeException $e) {
    print('EXCHANGERATES_ACCESS_KEY is not set. Check your .env file.' . PHP_EOL);
    exit();
}

$configData = require_once(Config::CONFIG_FILE);
$config = new Config($configData);

try {
    $transactionsService = DIContainer::getInstance()->getTransactionsService($config, $inputFile);
    $cardInfoService = DIContainer::getInstance()->getCardInfoService($config);
    $ratesService = DIContainer::getInstance()->getRatesService($config);
    $ratesService->getRates();

    $transactions = $transactionsService->getTransactions();

    /**
     * @var Transaction $transaction
     */
    foreach ($transactions as $transaction) {
        $card = $cardInfoService->getCardInfo($transaction->getBin());
        $isEUCard = $cardInfoService->isEUCard($card);

        $rate = $ratesService->getRate($transaction->getCurrency());
        $transaction = $transactionsService->calculateComission(
            currencyRate: $rate,
            transaction: $transaction,
            isEuCard: $isEUCard
        );
        print $transaction->getComission()->getAmount() . $transaction->getComission()->getCurrency() . PHP_EOL;
    }
} catch (AppException $e) {
    print ($e->getMessage() . PHP_EOL);
}

exit(0);


