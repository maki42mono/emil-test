<?php

declare(strict_types=1);

namespace App\Dto;

use App\Repository\DiscountRepository;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints as Assert;

class PriceRequest
{
    #[Assert\NotBlank]
    #[Assert\GreaterThanOrEqual(1)]
    protected int $productId;
    #[Assert\NotBlank]
    #[Assert\Regex('/^DE\d{9}$|^IT\d{11}$|^FR\w{2}\d{9}$/')]
    protected string $taxNumber;
    protected ?string $couponCode;
    protected DiscountRepository $discountRepository;

    public function __construct(
        int $productId,
        string $taxNumber,
        ?string $couponCode,
        DiscountRepository $discountRepository
    ) {
        $this->productId = $productId;
        $this->taxNumber = $taxNumber;
        $this->couponCode = $couponCode;
        $this->discountRepository = $discountRepository;
    }

    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context): void
    {
        $codes = $this->discountRepository->findAllCodes();
        if (isset($this->couponCode) && !array_key_exists($this->couponCode, $codes)) {
            $context
                ->buildViolation('The coupon is not valid')
                ->atPath('couponCode')
                ->addViolation();
        }
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getTaxNumber(): string
    {
        return $this->taxNumber;
    }

    public function getCouponCode(): ?string
    {
        return $this->couponCode;
    }
}