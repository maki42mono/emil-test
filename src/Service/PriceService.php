<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\PriceRequest;
use App\Entity\Product;
use App\Model\CalculatePriceModel;

class PriceService
{
    public function calculatePrice(CalculatePriceModel $calculatePrice): int
    {
        return $calculatePrice->product->getPrice() * (100 - $calculatePrice->priceRequest->getDiscount()) / 100;
    }
}