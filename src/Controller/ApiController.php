<?php

namespace App\Controller;

use App\Dto\PriceRequest;
use App\Dto\PriceResponse;
use App\Repository\ProductRepository;
use App\Service\PriceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

class ApiController extends AbstractController
{
    #[Route('/calculate-price', methods: ['POST', 'GET'])]
    public function calculatePrice(
        #[MapRequestPayload] PriceRequest $priceDto,
        ProductRepository $productRepository,
        PriceService $priceService
    ): Response
    {
        $product = $productRepository->find($priceDto->product);
        if (empty($product)) {
            return $this->json(['error' => 'Product not found'], 404);
        }

        $priceResponse = new PriceResponse($priceService->calculatePrice($priceDto, $product));
        return $this->json($priceResponse);
    }

    #[Route('/purchase', methods: ['POST'])]
    public function purchase(Purchase $purchase, PaypalPaymentProcessor $paypalPaymentProcessor, StripePaymentProcessor $stripePaymentProcessor): Response
    {
        $paypalPaymentProcessor->pay(123);

        return $this->json([]);
    }
}
