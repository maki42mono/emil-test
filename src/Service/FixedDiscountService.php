<?php

declare(strict_types=1);

namespace App\Service;

class FixedDiscountService extends AbstractDiscountService
{
    public function getPriceWithDiscount(): int
    {
        return $this->product->getPrice() - $this->discount->getValue();
    }
}