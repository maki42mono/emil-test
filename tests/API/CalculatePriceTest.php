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

class CalculatePriceTest extends ApiTestCase
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
        $couponCode = '123';
        static::createClient()->request(
            'POST',
            '/calculate-price',
            [
                'body' => json_encode([
                    'product' => -12,
                    'taxNumber' => 'DE1234567892',
                    'couponCode' => $couponCode,
                ]),
            ]
        );
        $response = [
            'success' => false,
            'message' => 'Incorrect request data',
            'data' => [
                'productId' => 'This value should be greater than or equal to 1.',
                'taxNumber' => 'This value is not valid.',
                'couponCode.couponCode' => "Coupon $couponCode does not exist.",
            ],
        ];
        $this->assertResponseStatusCodeSame(400);
        $this->assertJsonContains($response);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testProductNotExist()
    {
        static::createClient()->request(
            'POST',
            '/calculate-price',
            [
                'body' => json_encode([
                    'product' => 1,
                    'taxNumber' => 'DE123456789',
                ]),
            ]
        );
        $response = [
            'success' => false,
            'message' => ClientException::PRODUCT_NOT_FOUND,
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
    public function testWithExistingModels(
        int $price,
        string $taxNumber,
        int $responseCode,
        array $responseBody,
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
            '/calculate-price',
            [
                'body' => json_encode([
                    'product' => $product->getId(),
                    'taxNumber' => $taxNumber,
                    'couponCode' => $couponCode,
                ]),
            ]
        );
        $this->assertResponseStatusCodeSame($responseCode);
        $this->assertJsonContains($responseBody);
    }

    public function requestWithExistingModelsDataProvider(): Generator
    {
        yield 'Success, without a coupon' => [10000, 'IT12345678900', 200, ['price' => 122]];
        yield 'Success, with a coupon' => [10000, 'DE123456789', 200, ['price' => 116.63], 2, 199];
        yield 'Error, negative price' => [10, 'DE123456789', 400, ['success' => false, 'message' => ClientException::NEGATIVE_DISCOUNT], 2, 2000];
    }
}
