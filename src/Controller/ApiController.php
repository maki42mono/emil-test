<?php

namespace App\Controller;

use App\Builder\CalculatePriceBuilder;
use App\Dto\PriceRequest;
use App\Dto\PriceRequestOld;
use App\Dto\PriceResponse;
use App\Repository\DiscountRepository;
use App\Service\PriceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

class ApiController extends AbstractController
{
    /*#[Route('/calculate-price-old', methods: ['POST'])]
    public function calculatePriceOld(
        Request $request,
        PriceService $priceService,
        CalculatePriceBuilder $calculatePriceBuilder,
        DiscountRepository $discountRepository,
        ValidatorInterface $validator
    ): Response
    {
        $requestArray = $request->toArray();
        $priceRequest = new PriceRequest(
            $requestArray['product'],
            $requestArray['taxNumber'],
            $requestArray['couponCode'],
            $discountRepository
        );
        $violations = $validator->validate($priceRequest);
        if (count($violations) > 0) {
            dd($violations);
        }
        $calculatePrice = $calculatePriceBuilder->buildFromPriceRequestDto($priceRequest);
        $priceResponse = new PriceResponse($priceService->calculatePrice($calculatePrice));
        return $this->json($priceResponse);
    }*/

    #[Route('/calculate-price', methods: ['POST'])]
    public function calculatePrice(
        Request $request,
        PriceService $priceService,
        CalculatePriceBuilder $calculatePriceBuilder,
        DiscountRepository $discountRepository,
        ValidatorInterface $validator
    ): Response
    {
        $requestArray = $request->toArray();
        $priceRequest = new PriceRequest(
            $requestArray['product'],
            $requestArray['taxNumber'],
            $requestArray['couponCode'],
            $discountRepository
        );
        $violations = $validator->validate($priceRequest);
        if (count($violations) > 0) {
            dd($violations);
        }
        $calculatePrice = $calculatePriceBuilder->buildFromPriceRequestDto($priceRequest);
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
