<?php

declare(strict_types=1);

namespace App\Exception;

class ClientException extends AbstractPublicException
{
    public const NEGATIVE_DISCOUNT = "You can't use this coupon. The price can't be less than 0";
    public const REQUEST_DATA = "Incorrect request data";
    public const PRODUCT_NOT_FOUND = "Product not found";
    public const STRIPE_PAYMENT_ERROR = "The price is too low";
    public const PAYPAL_PAYMENT_ERROR = "The price is too high";

    public function __construct(string $message, array $payload = [])
    {
        parent::__construct($message, 400, $payload);
    }
}