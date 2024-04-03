<?php

namespace App\Tests\Integration;

use App\Dto\PriceRequest;
use App\Exception\ClientException;
use App\Factory\DiscountFactory;
use App\Factory\ProductFactory;
use App\Service\PriceService;
use Generator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class PriceServiceTest extends KernelTestCase
{
    use ResetDatabase, Factories;

    public function setUp(): void
    {
        self::bootKernel();
    }

    /**
     * @throws ClientException
     * @dataProvider priceRequestDataProvider
     */
    public function testCalculate(
        string $name,
        int $price,
        string $taxNumber,
        float $priceResult,
        ?int $couponType = null,
        ?int $couponValue = null
    ) {
        $product = ProductFactory::createOne(
            [
                'name' => $name,
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
        $priceRequest = new PriceRequest($product->getId(), $taxNumber, $couponCode);
        /** @var PriceService $priceService */
        $priceService = self::getContainer()->get(PriceService::class);
        $calculated = $priceService->calculate($priceRequest);
        $this->assertEquals($priceResult, $calculated->getPriceFloat());
    }

    public function priceRequestDataProvider(): Generator
    {
        yield 'No coupon' => ['Iphone', 10000, 'FRAA123456789', 120.0];
        yield 'Percent coupon' => ['Iphone', 10000, 'DE123456789', 107.1, 1, 1000];
        yield 'Fixed coupon' => ['Iphone', 10000, 'IT12345678900', 96.39, 2, 2099];
    }
}
