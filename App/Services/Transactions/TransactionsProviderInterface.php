<?php

namespace App\Services\Transactions;

interface TransactionsProviderInterface
{
    public function getTransactions(): array;
}