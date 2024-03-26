<?php

namespace App\Repository;

use App\Entity\Discount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Discount>
 *
 * @method Discount|null find($id, $lockMode = null, $lockVersion = null)
 * @method Discount|null findOneBy(array $criteria, array $orderBy = null)
 * @method Discount[]    findAll()
 * @method Discount[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiscountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Discount::class);
    }

    /**
     * @return string[]
     */
    public function findAllCodes(): array
    {
        $codes = $this->createQueryBuilder('d')
            ->select('d.code')
            ->getQuery()
            ->getScalarResult();

        return array_flip(array_column($codes, 'code'));
    }

    public function findByCode(string $code): Discount
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.code = :code')
            ->setParameter('code', $code)
            ->getQuery()
            ->getSingleResult();
    }
}
