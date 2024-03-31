<?php

declare(strict_types=1);

namespace App\Service\payment;

use App\Exception\ClientException;

interface PaymentInterface
{
    /**
     * @throws ClientException
     */
    public function proceed(float $price): void;
}