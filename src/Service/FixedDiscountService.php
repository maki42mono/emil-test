<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\ClientException;
use App\Model\PriceModel;

class FixedDiscountService extends AbstractDiscountService
{
    /**
     * @throws ClientException
     */
    public function getPriceWithDiscount(): PriceModel
    {
        $result = $this->priceModel->price - $this->discount->getValue();
        if ($result >= 0) {
            return new PriceModel($result);
        }

        throw new ClientException( ClientException::NEGATIVE_DISCOUNT);
    }
}