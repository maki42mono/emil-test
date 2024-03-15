<?php

namespace App\Controller;

use App\Builder\CalculatePriceBuilder;
use App\Dto\PriceRequest;
use App\Dto\PriceResponse;
use App\Service\PriceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

class ApiController extends AbstractController
{
    #[Route('/calculate-price', methods: ['POST'])]
    public function calculatePrice(
        #[MapRequestPayload] PriceRequest $priceDto,
        PriceService $priceService,
        CalculatePriceBuilder $calculatePriceBuilder
    ): Response
    {
//        todo: ловить ошибку
        $calculatePrice = $calculatePriceBuilder->buildFromPriceRequestDto($priceDto);
        $priceResponse = new PriceResponse($priceService->calculatePrice($calculatePrice));
        return $this->json($priceResponse);
    }

    #[Route('/purchase', methods: ['POST'])]
    public function purchase(Purchase $purchase, PaypalPaymentProcessor $paypalPaymentProcessor, StripePaymentProcessor $stripePaymentProcessor): Response
    {
        $paypalPaymentProcessor->pay(123);

        return $this->json([]);
    }
}
