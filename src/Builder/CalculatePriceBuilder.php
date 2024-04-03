<?php

declare(strict_types=1);

namespace App\Builder;

use App\Dto\PriceRequest;
use App\Exception\ClientException;
use App\Model\CalculatePriceModel;
use App\Repository\DiscountRepository;
use App\Repository\ProductRepository;
use Exception;

readonly class CalculatePriceBuilder
{
    public function __construct(
        private ProductRepository $productRepository,
        private DiscountRepository $discountRepository
    )
    {
    }

    /**
     * @throws ClientException
     */
    public function buildFromPriceRequestDto(PriceRequest $priceRequest): CalculatePriceModel
    {
        $product = $this->productRepository->find($priceRequest->productId);
        if (!$product) {
            throw new ClientException( ClientException::PRODUCT_NOT_FOUND);
        }
        $discount = $priceRequest->couponCode ? $this->discountRepository->findByCode($priceRequest->couponCode) : null;
        $priceModel = PriceBuilder::buildFromProduct($product);
        $country = substr($priceRequest->taxNumber, 0, 2);
        return new CalculatePriceModel($priceModel, $country, $discount);
    }
}