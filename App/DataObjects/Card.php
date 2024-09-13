<?php declare(strict_types = 1);

namespace App\DataObjects;

class Card
{
    private string $country;

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): void
    {
        $this->country = $country;
    }
}
