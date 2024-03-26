<?php

declare(strict_types=1);

namespace App\Service;

use App\Exceptions\ClientException;

class FixedDiscountService extends AbstractDiscountService
{
    /**
     * @throws ClientException
     */
    public function getPriceWithDiscount(): int
    {
        $result = $this->product->getPrice() - $this->discount->getValue();
        if ($result >= 0) {
            return $result;
        }

        throw new ClientException(null, ClientException::ERROR_NEGATIVE_DISCOUNT);
    }
}