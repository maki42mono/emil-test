<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Discount;
use App\Repository\DiscountRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class PriceRequestOld
{
//    private ?Discount $discount;
//    private static ?DiscountRepository $discountRepository;

    public function __construct(
        #[Assert\NotBlank]
        #[Assert\GreaterThanOrEqual(1)]
        public readonly int $product,

        #[Assert\NotBlank]
        #[Assert\Regex('/^DE\d{9}$|^IT\d{11}$|^FR\w{2}\d{9}$/')]
        public readonly string $taxNumber,

        public readonly ?string $couponCode

    ) {
    }

    /*public function getDiscount(): Discount
    {
        return $this->discount;
    }*/

   /* #[Assert\Callback]
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
    }*/

    /*public static function getCouponCodes(): array
    {
        if (!isset(self::$discountRepository)) {
            return [];
        }

        return self::$discountRepository->findAllCodes();
    }

    public static function setDiscountRepository(DiscountRepository $discountRepository): void
    {
        self::$discountRepository = $discountRepository;
    }*/
    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context, DiscountRepository $discountRepository, mixed $payload): void
    {
        if (!in_array($this->couponCode, $discountRepository->findAllCodes())) {
            $context
                ->buildViolation('The coupon is not valid')
                ->atPath('couponCode')
                ->addViolation()
            ;
        }
    }
}