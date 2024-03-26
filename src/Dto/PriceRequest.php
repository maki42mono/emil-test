<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Discount;
use App\Repository\DiscountRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class PriceRequest
{
    private ?Discount $discount;

    public function __construct(
        #[Assert\NotBlank]
        #[Assert\GreaterThanOrEqual(1)]
        public readonly int $product,

        #[Assert\NotBlank]
        #[Assert\Regex('/^DE\d{9}$|^IT\d{11}$|^FR\w{2}\d{9}$/')]
        public readonly string $taxNumber,

//        #[Assert\Choice(callback: 'getCouponCodes')]
        public readonly ?string $couponCode,
        private readonly DiscountRepository $discountRepository

    ) {
        if ($couponCode) {
            $this->discount = $discountRepository->findByCode($couponCode);
        }
    }

    public function getDiscount(): Discount
    {
        return $this->discount;
    }

    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context): void
    {
        if (!$this->couponCode) {
            return;
        }
        if (!in_array($this->couponCode, $this->discountRepository->findAllCodes())) {
            $context
                ->buildViolation('The coupon is not valid')
                ->atPath('couponCode')
                ->addViolation()
            ;
        }
    }
}