<?php

declare(strict_types=1);

namespace App\Exceptions;

class ClientException extends AbstractPublicException
{
    public const ERROR_NEGATIVE_DISCOUNT = 1;
    public const ERROR_REQUEST_DATA = 2;
    private const ERROR_MESSAGES = [
        self::ERROR_NEGATIVE_DISCOUNT => "You can't use this coupon. The price can't be less than 0",
        self::ERROR_REQUEST_DATA => "Incorrect request data",
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