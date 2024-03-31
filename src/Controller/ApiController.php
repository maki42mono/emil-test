<?php

namespace App\Controller;

use App\Dto\PriceRequest;
use App\Dto\PriceResponse;
use App\Dto\PurchaseRequest;
use App\Exception\ClientException;
use App\Repository\DiscountRepository;
use App\Service\payment\PaymentService;
use App\Service\PriceService;
use App\Validator\APIValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ApiController extends AbstractController
{
    /**
     * @throws ClientException
     */
    #[Route('/calculate-price', methods: ['POST'])]
    public function calculatePrice(
        Request $request,
        PriceService $priceService,
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
        $priceResponse = new PriceResponse($priceService->calculate($priceRequest));

        return $this->json($priceResponse);
    }

    /**
     * @throws ClientException
     */
    #[Route('/purchase', methods: ['POST'])]
    public function purchase(
        Request $request,
        PaymentService $paymentService,
        DiscountRepository $discountRepository,
        APIValidator $validator
    ): Response {
        $requestArray = $request->toArray();
        $purchaseRequest = new PurchaseRequest(
            $requestArray['product'],
            $requestArray['taxNumber'],
            $requestArray['couponCode'] ?? null,
            $requestArray['paymentProcessor'],
            $discountRepository
        );
        $validator->validate($purchaseRequest);
        $paymentService->proceed($purchaseRequest);

        return (new Response())->setStatusCode(200);
    }
}
