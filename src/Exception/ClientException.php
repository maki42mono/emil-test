<?php

declare(strict_types=1);

namespace App\Exception;

class ClientException extends AbstractPublicException
{
    public const NEGATIVE_DISCOUNT = 1;
    public const REQUEST_DATA = 2;
    public const PRODUCT_NOT_FOUND = 3;
    public const STRIPE_PAYMENT_ERROR = 4;
    private const ERROR_MESSAGES = [
        self::NEGATIVE_DISCOUNT => "You can't use this coupon. The price can't be less than 0",
        self::REQUEST_DATA => "Incorrect request data",
        self::PRODUCT_NOT_FOUND => "Product not found",
        self::STRIPE_PAYMENT_ERROR => "The price is too low",
    ];

    public function __construct(?string $message, int $errorCode = null, array $payload = [])
    {
        $message = $message ?? '';
        if (isset($errorCode)) {
            $message = self::ERROR_MESSAGES[$errorCode];
        }
        parent::__construct($message, 400, $payload);
    }
}