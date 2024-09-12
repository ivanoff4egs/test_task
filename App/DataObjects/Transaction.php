<?php declare(strict_types=1);

namespace App\DataObjects;

class Transaction
{
    private string $bin;

    private float $amount;

    private string $currency;

    private float $comission;

    public function getComission(): float
    {
        return $this->comission;
    }

    public function setComission(float $comission): void
    {
        $this->comission = $comission;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    public function getBin(): string
    {
        return $this->bin;
    }

    public function setBin(string $bin): void
    {
        $this->bin = $bin;
    }
}