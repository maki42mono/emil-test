<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\PriceModel;

class PercentDiscountService extends AbstractDiscountService
{
    public function getPriceWithDiscount(): PriceModel
    {
        $result = intval(
            (100 - ($this->discount->getValue() / 100)) * $this->priceModel->price / 10
        );

        return new PriceModel($result);
    }
}