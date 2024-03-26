<?php

declare(strict_types=1);

namespace App\Dto;

class PriceResponse
{
    public function __construct(
        private readonly int $price
    ) {
    }

    public function getPrice(): float
    {
        return round($this->price / 100, 2);
    }
}