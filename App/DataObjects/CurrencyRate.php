<?php declare(strict_types = 1);

namespace App\DataObjects;

class CurrencyRate
{
    private string $currencyTo;
    private float $rate;

    public function getCurrencyTo(): string
    {
        return $this->currencyTo;
    }

    public function setCurrencyTo(string $currencyTo): void
    {
        $this->currencyTo = $currencyTo;
    }

    public function getRate(): float
    {
        return $this->rate;
    }

    public function setRate(float $rate): void
    {
        $this->rate = $rate;
    }
}
