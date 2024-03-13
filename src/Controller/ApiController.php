<?php

namespace App\Controller;

use App\Dto\PriceDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

class ApiController extends AbstractController
{
    #[Route('/calculate-price', methods: ['POST', 'GET'])]
    public function calculatePrice(#[MapRequestPayload] PriceDto $priceDto): Response
    {
        dd($priceDto);
    }

    #[Route('/purchase', methods: ['POST'])]
    public function purchase(Purchase $purchase, PaypalPaymentProcessor $paypalPaymentProcessor, StripePaymentProcessor $stripePaymentProcessor): Response
    {
        $paypalPaymentProcessor->pay(123);

        return $this->json([]);
    }
}
