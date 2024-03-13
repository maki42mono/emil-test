<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\PriceRequest;
use App\Entity\Product;

class PriceService
{
    public function calculatePrice(PriceRequest $priceDto, Product $product): int
    {
        return $product->getPrice() * (100 - $priceDto->getDiscount()) / 100;
    }
}