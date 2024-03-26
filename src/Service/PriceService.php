<?php

declare(strict_types=1);

namespace App\Service;

use App\Builder\DiscountServiceBuilder;
use App\Dto\PriceRequestOld;
use App\Entity\Product;
use App\Model\CalculatePriceModel;
use App\Repository\DiscountRepository;

readonly class PriceService
{
    public function __construct(private DiscountRepository $discountRepository)
    {
    }

    public function calculatePrice(CalculatePriceModel $calculatePrice): int
    {
        $product = $calculatePrice->product;
        $priceRequest = $calculatePrice->priceRequest;
        if (empty($priceRequest->couponCode)) {
            return $product->getPrice();
        }
        $discount = $this->discountRepository->findByCode($priceRequest->couponCode);
        $discountService = DiscountServiceBuilder::getDiscountService($product, $discount);

        return $discountService->getPriceWithDiscount();
    }
}