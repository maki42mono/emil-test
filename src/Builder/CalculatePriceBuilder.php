<?php

declare(strict_types=1);

namespace App\Builder;

use App\Dto\PriceRequest;
use App\Model\CalculatePriceModel;
use App\Repository\DiscountRepository;
use App\Repository\ProductRepository;
use Exception;

class CalculatePriceBuilder
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly DiscountRepository $discountRepository
    )
    {
    }

    /**
     * @throws Exception
     */
    public function buildFromPriceRequestDto(PriceRequest $priceRequest): CalculatePriceModel
    {
        $product = $this->productRepository->find($priceRequest->productId);
        if (!$product) {
            throw new Exception('Product not found');
        }
        $discount = $priceRequest->couponCode ? $this->discountRepository->findByCode($priceRequest->couponCode) : null;
        return new CalculatePriceModel($priceRequest, $product, $discount);
    }
}