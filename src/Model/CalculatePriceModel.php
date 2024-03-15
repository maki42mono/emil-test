<?php

declare(strict_types=1);

namespace App\Model;

use App\Dto\PriceRequest;
use App\Entity\Product;

class CalculatePriceModel
{
    public function __construct(
        public readonly PriceRequest $priceRequest,
        public readonly Product $product
    )
    {}
}