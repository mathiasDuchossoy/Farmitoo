<?php

namespace App\Repository;

use App\Entity\Brand;
use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Brand|null find($id, $lockMode = null, $lockVersion = null)
 * @method Brand|null findOneBy(array $criteria, array $orderBy = null)
 * @method Brand[]    findAll()
 * @method Brand[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BrandRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Brand::class);
    }

    public function findByOrder(Order $order)
    {
        return $this->createQueryBuilder('b')
            ->select('b')
            ->innerJoin('b.products', 'p')
            ->innerJoin('p.items', 'i')
            ->innerJoin('i.order', 'o')
            ->where('o.id = :id')
            ->setParameter('id', $order->getId())
            ->getQuery()
            ->getResult();
    }
}
