<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Discount;
use App\Entity\Product;
use App\Repository\DiscountRepository;

abstract class AbstractDiscountService
{
    public function __construct(protected readonly Product $product, protected readonly Discount $discount)
    {
    }

    abstract public function getPriceWithDiscount(): int;
}