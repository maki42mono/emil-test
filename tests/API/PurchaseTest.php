<?php

namespace App\Tests\API;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Exception\ClientException;
use App\Factory\DiscountFactory;
use App\Factory\ProductFactory;
use Generator;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class PurchaseTest extends ApiTestCase
{
    use ResetDatabase, Factories;

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testValidation()
    {
        $couponCode = 'couponCode';
        static::createClient()->request(
            'POST',
            '/purchase',
            [
                'body' => json_encode(
                    [
                        'product' => -12,
                        'taxNumber' => 'FRAA123456789aa',
                        'couponCode' => $couponCode,
                        'paymentProcessor' => 'apple',
                    ]
                ),
            ]
        );

        $response = [
            'success' => false,
            'message' => 'Incorrect request data',
            'data' => [
                'priceRequest.productId' => 'This value should be greater than or equal to 1.',
                'priceRequest.taxNumber' => 'This value is not valid.',
                'priceRequest.couponCode.couponCode' => "Coupon $couponCode does not exist.",
                'paymentProcessor' => 'Choose a valid payment service.',
            ],
        ];
        $this->assertResponseStatusCodeSame(400);
        $this->assertJsonContains($response);
    }

    /**
     * @dataProvider requestWithExistingModelsDataProvider
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testSomething(
        int $price,
        string $taxNumber,
        int $responseCode,
        string $payment,
        array $responseBody = [],
        ?int $couponType = null,
        ?int $couponValue = null
    ): void {
        $product = ProductFactory::createOne(
            [
                'name' => 'A',
                'price' => $price,
            ]
        );
        $couponCode = null;
        if (isset($couponType) && isset($couponValue)) {
            $couponCode = 'AAA';
            DiscountFactory::createOne(
                [
                    'code' => $couponCode,
                    'type' => $couponType,
                    'value' => $couponValue,
                ]
            );
        }
        static::createClient()->request(
            'POST',
            '/purchase',
            [
                'body' => json_encode(
                    [
                        'product' => $product->getId(),
                        'taxNumber' => $taxNumber,
                        'couponCode' => $couponCode,
                        'paymentProcessor' => $payment,
                    ]
                ),
            ]
        );

        $this->assertResponseStatusCodeSame($responseCode);
        if (!empty($responseBody)) {
            $this->assertJsonContains($responseBody);
        }
    }

    public function requestWithExistingModelsDataProvider(): Generator
    {
        yield 'Success, paypal' => [10000, 'IT12345678900', 200, 'paypal'];
        yield 'Success, stripe' => [10000, 'FRAA123456789', 200, 'stripe', [], 1, 1200];
        yield 'Error, too low price' => [
            10000, 'FRAA123456789', 400, 'stripe',
            ['success' => false, 'message' => ClientException::STRIPE_PAYMENT_ERROR], 1, 8000,
        ];
        yield 'Error, too low high' => [
            100000000, 'FRAA123456789', 400, 'paypal',
            ['success' => false, 'message' => ClientException::PAYPAL_PAYMENT_ERROR],
        ];
    }
}
