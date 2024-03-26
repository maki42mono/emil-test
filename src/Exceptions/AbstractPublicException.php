<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

abstract class AbstractPublicException extends Exception
{
    public function __construct(string $message, int $errorCode = null, public readonly array $payload = [])
    {
//        dd($this->payload);
        parent::__construct($message, $errorCode);
    }
}