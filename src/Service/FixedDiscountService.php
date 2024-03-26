<?php

declare(strict_types=1);

namespace App\Service;

use App\Exceptions\PublicException;

class FixedDiscountService extends AbstractDiscountService
{
    /**
     * @throws PublicException
     */
    public function getPriceWithDiscount(): int
    {
        $result = $this->product->getPrice() - $this->discount->getValue();
        if ($result >= 0) {
            return $result;
        }

        throw new PublicException(null, PublicException::ERROR_NEGATIVE_DISCOUNT);
    }
}