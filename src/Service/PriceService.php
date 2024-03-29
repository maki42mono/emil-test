<?php

declare(strict_types=1);

namespace App\Service;

use App\Builder\DiscountServiceBuilder;
use App\Builder\PriceBuilder;
use App\Model\CalculatePriceModel;
use App\Model\PriceModel;

readonly class PriceService
{
    public function calculate(CalculatePriceModel $calculatePrice): PriceModel
    {
        $calculatePrice = $this->calculatePriceWithDiscount($calculatePrice);

        return $this->calculatePriceWithTax($calculatePrice)->getPriceModel();
    }

    private function calculatePriceWithDiscount(CalculatePriceModel $calculatePrice): CalculatePriceModel
    {
        $discount = $calculatePrice->discount;
        $priceModel = $calculatePrice->getPriceModel();
        if (empty($discount)) {
            return $calculatePrice;
        }
        $discountService = DiscountServiceBuilder::getDiscountService($priceModel, $discount);

        return $calculatePrice->setPriceModel($discountService->getPriceWithDiscount());
    }

    private function calculatePriceWithTax(CalculatePriceModel $calculatePrice): CalculatePriceModel
    {
        $price = intval($calculatePrice->getPriceModel()->price * (1 + $calculatePrice->getTaxPercent() / 100));

        return $calculatePrice->setPriceModel(new PriceModel($price));
    }
}