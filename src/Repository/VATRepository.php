<?php

namespace App\Repository;

use App\Entity\Order;
use App\Entity\VAT;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VAT|null find($id, $lockMode = null, $lockVersion = null)
 * @method VAT|null findOneBy(array $criteria, array $orderBy = null)
 * @method VAT[]    findAll()
 * @method VAT[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VATRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VAT::class);
    }

    public function findByOrder(Order $order)
    {
        return $this->createQueryBuilder('v')
            ->innerJoin('v.brand', 'b')
            ->innerJoin('b.products', 'p')
            ->innerJoin('p.items', 'i')
            ->innerJoin('i.order', 'o')
            ->where('o.id = :id')
            ->setParameter('id', $order->getId())
            ->getQuery()
            ->getResult();
    }
}
