<?php

declare(strict_types=1);

namespace App\Model;

readonly class PriceModel
{
    public function __construct(public int $price)
    {
    }

    public function getPriceFloat(): float
    {
        return round($this->price / 100, 2);
    }
}