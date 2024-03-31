<?php

declare(strict_types=1);

namespace App\Service\payment;

use App\Exception\ClientException;
use Exception;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;

class PaypalPaymentService extends PaypalPaymentProcessor implements PaymentInterface
{
    public function proceed(float $price): void
    {
        try {
            $this->pay(intval($price));
        } catch (Exception $e) {
            throw new ClientException($e->getMessage());
        }
    }
}