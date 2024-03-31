<?php

declare(strict_types=1);

namespace App\Dto;

use App\Repository\DiscountRepository;
use Symfony\Component\Validator\Constraints as Assert;

class PurchaseRequest extends PriceRequest
{
    public const PAYMENTS = [
        'paypal' => 1,
        'stripe' => 2,
    ];

    public function __construct(
        int $productId,
        string $taxNumber,
        ?string $couponCode,
        #[Assert\NotBlank]
        #[Assert\Choice(callback: 'getPayments', message: 'Choose a valid genre.')]
        public readonly string $paymentProcessor,
        DiscountRepository $discountRepository
    ) {
        parent::__construct($productId, $taxNumber, $couponCode, $discountRepository);
    }

    public static function getPayments(): array
    {
        return array_keys(self::PAYMENTS);
    }
}