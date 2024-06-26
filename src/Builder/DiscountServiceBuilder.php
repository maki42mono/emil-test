<?php

declare(strict_types=1);

namespace App\Builder;

use App\Entity\Discount;
use App\Entity\Product;
use App\Model\PriceModel;
use App\Service\AbstractDiscountService;
use App\Service\FixedDiscountService;
use App\Service\PercentDiscountService;

class DiscountServiceBuilder
{
    private const TYPES = [
        1 => PercentDiscountService::class,
        2 => FixedDiscountService::class,
    ];

    public static function getDiscountService(PriceModel $priceModel, Discount $discount): AbstractDiscountService
    {
        return new (self::TYPES[$discount->getType()])($priceModel, $discount);
    }
}