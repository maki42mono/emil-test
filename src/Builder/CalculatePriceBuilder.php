<?php

declare(strict_types=1);

namespace App\Builder;

use App\Dto\PriceRequest;
use App\Model\CalculatePriceModel;
use App\Repository\ProductRepository;

class CalculatePriceBuilder
{
    public function __construct(private ProductRepository $productRepository)
    {
    }

    /**
     * @throws \Exception
     */
    public function buildFromPriceRequestDto(PriceRequest $priceRequest): CalculatePriceModel
    {
        $product = $this->productRepository->find($priceRequest->product);
        if (!$product) {
            throw new \Exception('Product not found');
        }
        return new CalculatePriceModel($priceRequest, $product);
    }
}