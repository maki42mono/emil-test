<?php

declare(strict_types=1);

namespace App\Service;

class PercentDiscountService extends AbstractDiscountService
{
    public function getPriceWithDiscount(): int
    {
        return intval(
            (100 - ($this->discount->getValue() / 100)) * $this->product->getPrice()
        );
    }
}