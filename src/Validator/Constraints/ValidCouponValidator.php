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
        if (empty($value)) {
            return;
        }
        $discount = $this->discountRepository->findByCode($value);
        if (empty($discount)) {
            $this->context
                ->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->atPath('couponCode')
                ->addViolation();
        }
    }
}