<?php

declare(strict_types=1);

namespace App\Listener;

interface ListenableExceptionInterface
{
    public function toArray(): array;
}