<?php

declare(strict_types=1);

namespace App\Builder;

use App\Entity\Product;
use App\Model\PriceModel;

class PriceBuilder
{
    public static function buildFromProduct(Product $product)
    {
        return new PriceModel($product->getPrice());
    }
}