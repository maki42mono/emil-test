<?php

declare(strict_types=1);

namespace App\Model;

use App\Dto\PriceRequest;
use App\Entity\Discount;
use App\Entity\Product;

readonly class CalculatePriceModel
{
    public function __construct(
        public PriceRequest $priceRequest,
        public Product $product,
        public ?Discount $discount = null
    )
    {
    }
}