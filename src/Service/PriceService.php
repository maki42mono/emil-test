<?php

declare(strict_types=1);

namespace App\Service;

use App\Builder\DiscountServiceBuilder;
use App\Builder\PriceBuilder;
use App\Model\CalculatePriceModel;
use App\Model\PriceModel;

readonly class PriceService
{
    private function calculatePriceWithDiscount(CalculatePriceModel $calculatePrice): PriceModel
    {
        $discount = $calculatePrice->discount;
        $priceModel = $calculatePrice->getPriceModel();
        if (empty($discount)) {
            return $priceModel;
        }
        $discountService = DiscountServiceBuilder::getDiscountService($priceModel, $discount);

        return $discountService->getPriceWithDiscount();
    }

    private function calculatePriceWithTax(): PriceModel
    {

    }
}