<?php

declare(strict_types=1);

namespace App\Service;

use App\Builder\DiscountServiceBuilder;
use App\Model\CalculatePriceModel;

readonly class PriceService
{
    public function calculatePrice(CalculatePriceModel $calculatePrice): int
    {
        $product = $calculatePrice->product;
        $discount = $calculatePrice->discount;
        if (empty($discount)) {
            return $product->getPrice();
        }
        $discountService = DiscountServiceBuilder::getDiscountService($product, $discount);

        return $discountService->getPriceWithDiscount();
    }
}