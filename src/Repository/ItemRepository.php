<?php

namespace App\Repository;

use App\Entity\Brand;
use App\Entity\Item;
use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Item|null find($id, $lockMode = null, $lockVersion = null)
 * @method Item|null findOneBy(array $criteria, array $orderBy = null)
 * @method Item[]    findAll()
 * @method Item[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Item::class);
    }

    public function findByOrderAndBrand(Order $order, Brand $brand)
    {
        return $this->createQueryBuilder('i')
            ->innerJoin('i.order', 'o')
            ->innerJoin('i.product', 'p')
            ->innerJoin('p.brand', 'b')
            ->where('o.id = :orderId')
            ->andWhere('b.id = :brandId')
            ->setParameters(
                [
                    'orderId' => $order->getId(),
                    'brandId' => $brand->getId(),
                ]
            )
            ->getQuery()
            ->getResult();
    }
}
