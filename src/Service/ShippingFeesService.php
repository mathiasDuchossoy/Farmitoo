<?php

namespace App\Service;

use App\Calculator\ShippingFeesCalculator;
use App\Entity\Brand;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;

class ShippingFeesService
{
    /**
     * @var ShippingFeesCalculator
     */
    private $shippingFeesCalculator;

    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * @var ItemService
     */
    private $itemService;

    public function __construct(EntityManagerInterface $em, ItemService $itemService, ShippingFeesCalculator $shippingFeesCalculator)
    {
        $this->em = $em;
        $this->shippingFeesCalculator = $shippingFeesCalculator;
        $this->itemService = $itemService;
    }

    public function calculateForOrder(Order $order): int
    {
        $brands = $this->em->getRepository(Brand::class)->findAll();

        $shippingFees = 0;

        foreach ($brands as $brand) {
            $items = $this->itemService->getByBrandForOrder($brand, $order);

            if ($items->isEmpty()) {
                continue;
            }

            $shippingFees += $this->shippingFeesCalculator->calculate($items, $brand);
        }

        return $shippingFees;
    }
}
