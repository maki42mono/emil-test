<?php

namespace App\Factory;

use App\Entity\Discount;
use App\Repository\DiscountRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Discount>
 *
 * @method        Discount|Proxy                     create(array|callable $attributes = [])
 * @method static Discount|Proxy                     createOne(array $attributes = [])
 * @method static Discount|Proxy                     find(object|array|mixed $criteria)
 * @method static Discount|Proxy                     findOrCreate(array $attributes)
 * @method static Discount|Proxy                     first(string $sortedField = 'id')
 * @method static Discount|Proxy                     last(string $sortedField = 'id')
 * @method static Discount|Proxy                     random(array $attributes = [])
 * @method static Discount|Proxy                     randomOrCreate(array $attributes = [])
 * @method static DiscountRepository|RepositoryProxy repository()
 * @method static Discount[]|Proxy[]                 all()
 * @method static Discount[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Discount[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Discount[]|Proxy[]                 findBy(array $attributes)
 * @method static Discount[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Discount[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class DiscountFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'code' => self::faker()->text(10),
            'type' => self::faker()->numberBetween(1, 32767),
            'value' => self::faker()->numberBetween(1, 32767),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Discount $discount): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Discount::class;
    }
}
