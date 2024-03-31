<?php

namespace App\Controller;

use App\Builder\CalculatePriceBuilder;
use App\Dto\PriceRequest;
use App\Dto\PriceResponse;
use App\Dto\PurchaseRequest;
use App\Exception\ClientException;
use App\Repository\DiscountRepository;
use App\Service\PriceService;
use App\Validator\APIValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

class ApiController extends AbstractController
{
    /**
     * @throws ClientException
     */
    #[Route('/calculate-price', methods: ['POST'])]
    public function calculatePrice(
        Request $request,
        PriceService $priceService,
        CalculatePriceBuilder $calculatePriceBuilder,
        DiscountRepository $discountRepository,
        APIValidator $validator
    ): Response {
        $requestArray = $request->toArray();
        $priceRequest = new PriceRequest(
            $requestArray['product'],
            $requestArray['taxNumber'],
            $requestArray['couponCode'] ?? null,
            $discountRepository
        );
        $validator->validate($priceRequest);
        $calculatePrice = $calculatePriceBuilder->buildFromPriceRequestDto($priceRequest);
        $priceResponse = new PriceResponse($priceService->calculate($calculatePrice));

        return $this->json($priceResponse);
    }

    /**
     * @throws ClientException
     */
    #[Route('/purchase', methods: ['POST'])]
    public function purchase(
        Request $request,
        PriceService $priceService,
        CalculatePriceBuilder $calculatePriceBuilder,
        DiscountRepository $discountRepository,
        APIValidator $validator
    ): Response {
        $requestArray = $request->toArray();
        $purchaseRequest = new PurchaseRequest(
            $requestArray['product'],
            $requestArray['taxNumber'],
            $requestArray['couponCode'] ?? null,
            $requestArray['paymentProcessor'] ?? null,
            $discountRepository
        );
        $validator->validate($purchaseRequest);

        return $this->json([1 => 2]);
    }
}
