<?php

namespace App\Service;

use App\Calculator\ShippingFeesCalculator;
use App\Entity\Order;
use App\Repository\BrandRepository;

class ShippingFeesService
{
    /**
     * @var ShippingFeesCalculator
     */
    private $shippingFeesCalculator;

    /**
     * @var ItemService
     */
    private $itemService;

    /**
     * @var BrandRepository
     */
    private $brandRepository;

    public function __construct(ItemService $itemService, ShippingFeesCalculator $shippingFeesCalculator, BrandRepository $brandRepository)
    {
        $this->shippingFeesCalculator = $shippingFeesCalculator;
        $this->itemService = $itemService;
        $this->brandRepository = $brandRepository;
    }

    public function calculateForOrder(Order $order): int
    {
        $brands = $this->brandRepository->findByOrder($order);

        $shippingFees = 0;

        foreach ($brands as $brand) {
            $items = $this->itemService->getByBrandForOrder($brand, $order);

            $shippingFees += $this->shippingFeesCalculator->calculate($items, $brand->getShippingFees());
        }

        return $shippingFees;
    }
}
