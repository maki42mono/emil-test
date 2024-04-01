<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use function get_class;

#[\Attribute]
class ValidCoupon extends Constraint
{
    public string $message = 'Coupon {{ string }} does not exist.';

    public function validatedBy(): string
    {
        return get_class($this).'Validator';
    }
}