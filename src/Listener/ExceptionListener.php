<?php

declare(strict_types=1);

namespace App\Listener;

use App\Exceptions\AbstractPublicException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{
    public function __construct(private readonly string $env)
    {

    }
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        if ($exception instanceof AbstractPublicException) {
            $data = [
                'success' => false,
                'message' => $exception->getMessage(),
            ];
            $payload = $exception->payload;
            if (!empty($payload)) {
                $data['data'] = $payload;
            }
            $response = new JsonResponse($data);
            $response->setStatusCode($exception->getCode());
            $event->setResponse($response);
        } else if ($this->env !== 'dev') {
            $response = new JsonResponse([
                'success' => false,
                'message' => 'Oops... something went wrong'
            ]);
            $response->setStatusCode(500);
            $event->setResponse($response);
        }
    }
}