<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as MyAssert;

readonly class PriceRequest
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\GreaterThanOrEqual(1)]
        public int $productId,
        #[Assert\NotBlank]
        #[Assert\Regex('/^DE\d{9}$|^IT\d{11}$|^FR\w{2}\d{9}$/')]
        public string $taxNumber,
        #[MyAssert\ValidCoupon]
        public ?string $couponCode = null
    ) {
    }
}