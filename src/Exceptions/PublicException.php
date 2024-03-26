<?php

declare(strict_types=1);

namespace App\Exceptions;

class PublicException extends \Exception
{
    public const ERROR_NEGATIVE_DISCOUNT = 1;
    private const ERROR_MESSAGES = [
        self::ERROR_NEGATIVE_DISCOUNT => "You can't use this coupon. The price can't be less than 0",
    ];

    public function __construct(?string $message, int $errorCode = null)
    {
        if (isset($errorCode)) {
            parent::__construct(self::ERROR_MESSAGES[$errorCode]);
        } else {
            parent::__construct($message ?? '');
        }
    }
}