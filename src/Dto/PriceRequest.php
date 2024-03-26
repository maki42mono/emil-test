<?php

declare(strict_types=1);

namespace App\Dto;

use App\Repository\DiscountRepository;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;

class PriceRequest
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\GreaterThanOrEqual(1)]
        public readonly int $productId,
        #[Assert\NotBlank]
        #[Assert\Regex('/^DE\d{9}$|^IT\d{11}$|^FR\w{2}\d{9}$/')]
        public readonly string $taxNumber,
        public readonly ?string $couponCode,
        private readonly DiscountRepository $discountRepository
    )
    {
    }

    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context, mixed $payload): void
    {
        $codes = $this->discountRepository->findAllCodes();
        if (!array_key_exists($this->couponCode, $codes)) {
            $context
                ->buildViolation('The coupon is not valid')
                ->atPath('couponCode')
                ->addViolation()
            ;
        }
    }
}