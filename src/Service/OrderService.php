<?php

namespace App\Service;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityNotFoundException;

class OrderService
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * @throws EntityNotFoundException
     */
    public function getOneOrFail(): Order
    {
        $order = $this->orderRepository->findOneBy([]);

        if (!$order) {
            throw new EntityNotFoundException('No order found');
        }

        return $order;
    }
}
