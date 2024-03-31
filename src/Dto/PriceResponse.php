<?php

declare(strict_types=1);

namespace App\Dto;

use App\Model\PriceModel;

readonly class PriceResponse
{
    public float $price;

    public function __construct(
        PriceModel $priceModel
    ) {
        $this->price = $priceModel->getPriceFloat();
    }
}