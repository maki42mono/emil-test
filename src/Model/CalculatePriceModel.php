<?php

declare(strict_types=1);

namespace App\Model;

use App\Dto\PriceRequest;
use App\Entity\Discount;
use App\Entity\Product;

class CalculatePriceModel
{
    private const TAX_VALUES = [
        'DE' => 19,
        'IT' => 22,
        'FR' => 20,
        'GR' => 24,
    ];

    public function __construct(
        private PriceModel $priceModel,
        public readonly string $country,
        public readonly ?Discount $discount = null
    ) {
    }

    public function getPriceModel(): PriceModel
    {
        return $this->priceModel;
    }

    public function setPriceModel(PriceModel $priceModel): self
    {
        $this->priceModel = $priceModel;

        return $this;
    }

    public function getTaxPercent(): int
    {
        return self::TAX_VALUES[$this->country];
    }
}