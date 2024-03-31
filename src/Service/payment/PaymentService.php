<?php

declare(strict_types=1);

namespace App\Service\payment;

use App\Dto\PurchaseRequest;
use App\Exception\ClientException;
use App\Service\PriceService;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

class PaymentService
{
    public const PAYPAL = 'paypal';
    public const STRIPE = 'stripe';
    public const SERVICES = [self::PAYPAL, self::STRIPE];
    /**
     * @var PaymentInterface[]
     */
    private array $services;

    public function __construct(
        PaypalPaymentService $paypalPaymentService,
        StripePaymentService $stripePaymentService,
        private readonly PriceService $priceService
    ) {
        $this->services = [
            self::PAYPAL => $paypalPaymentService,
            self::STRIPE => $stripePaymentService,
        ];
    }

    /**
     * @throws ClientException
     */
    public function proceed(PurchaseRequest $purchaseRequest): void
    {
        $priceModel = $this->priceService->calculate($purchaseRequest->priceRequest);
        $this->services[$purchaseRequest->paymentProcessor]->proceed($priceModel->getPriceFloat());
    }
}