<?php

declare(strict_types=1);

namespace App\Dto;

use App\Repository\DiscountRepository;
use App\Service\payment\PaymentService;
use Symfony\Component\Validator\Constraints as Assert;

readonly class PurchaseRequest
{
    #[Assert\Valid]
    public PriceRequest $priceRequest;

    public function __construct(
        int $productId,
        string $taxNumber,
        #[Assert\NotBlank]
        #[Assert\Choice(choices: PaymentService::SERVICES, message: 'Choose a valid payment service.')]
        public string $paymentProcessor,
        ?string $couponCode = null
    ) {
        $this->priceRequest = new PriceRequest($productId, $taxNumber, $couponCode);
    }
}