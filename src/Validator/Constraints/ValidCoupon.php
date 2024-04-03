<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use AllowDynamicProperties;
use Symfony\Component\Validator\Attribute\HasNamedArguments;
use Symfony\Component\Validator\Constraint;
use function get_class;

#[AllowDynamicProperties]
#[\Attribute]
class ValidCoupon extends Constraint
{
    public string $message = 'Coupon {{ string }} does not exist.';

    public function __construct(string $message = null, array $groups = null, $payload = null)
    {
        parent::__construct([], $groups, $payload);

        $this->message = $message ?? $this->message;
    }

    public function validatedBy(): string
    {
        return get_class($this).'Validator';
    }
}