<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use App\Repository\DiscountRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ValidCouponValidator extends ConstraintValidator
{
    public function __construct(private readonly DiscountRepository $discountRepository)
    {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        $dicount = $this->discountRepository->findByCode($value);
        if (empty($dicount)) {
            $this->context
                ->buildViolation('The coupon is not valid.')
                ->atPath('couponCode')
                ->addViolation();
        }
    }
}