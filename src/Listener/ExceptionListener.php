<?php

declare(strict_types=1);

namespace App\Listener;

use App\Exception\AbstractPublicException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

readonly class ExceptionListener
{
    public function __construct(private string $env, private LoggerInterface $logger)
    {

    }
    public function onKernelException(ExceptionEvent $event): void
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
            $this->logger->debug($exception->getMessage());
        }
    }
}