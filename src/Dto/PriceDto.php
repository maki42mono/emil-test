<?php

declare(strict_types=1);

namespace App\Dto;
use Symfony\Component\Validator\Constraints as Assert;

class PriceDto
{
    private const COUPONS = [
        'XXX' => 10,
        'HAPPY' => 15,
        'HELLO' => 20,
        'GRANNY' => 30,
        'MAXIM' => 90,
    ];
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\GreaterThanOrEqual(1)]
        public readonly int $product,

        #[Assert\NotBlank]
        #[Assert\Regex('/^DE\d{9}$|^IT\d{11}$|^FR\w{2}\d{9}$/')]
        public readonly string $taxNumber,

        #[Assert\Choice(callback: 'getCouponCodes')]
        public readonly ?string $couponCode
    )
    {

    }

    public static function getCouponCodes(): array
    {
        return array_keys(self::COUPONS);
    }
}