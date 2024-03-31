<?php

declare(strict_types=1);

namespace App\Service\payment;

use App\Exception\ClientException;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

class StripePaymentService extends StripePaymentProcessor implements PaymentInterface
{
    public function proceed(float $price): void
    {
        if (!$this->processPayment($price)) {
            throw new ClientException('', ClientException::STRIPE_PAYMENT_ERROR);
        }
    }
}