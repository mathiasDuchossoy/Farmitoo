<?php

namespace App\Service;

use App\Calculator\ShippingFeesCalculator;
use App\Entity\Order;
use App\Entity\VAT;
use App\Repository\BrandRepository;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityNotFoundException;

class OrderService
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;

    /**
     * @var BrandRepository
     */
    private $brandRepository;

    /**
     * @var ItemService
     */
    private $itemService;

    /**
     * @var ShippingFeesCalculator
     */
    private $shippingFeesCalculator;

    /**
     * @var PromotionService
     */
    private $promotionService;

    public function __construct(
        OrderRepository $orderRepository,
        BrandRepository $brandRepository,
        ItemService $itemService,
        ShippingFeesCalculator $shippingFeesCalculator,
        PromotionService $promotionService
    )
    {
        $this->orderRepository = $orderRepository;
        $this->brandRepository = $brandRepository;
        $this->itemService = $itemService;
        $this->shippingFeesCalculator = $shippingFeesCalculator;
        $this->promotionService = $promotionService;
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

    public function calculateTotalInclTax(Order $order): float
    {
        /** @var VAT $vat */
        $totalInclTax = 0;
        $brands = $this->brandRepository->findByOrder($order);

        foreach ($brands as $brand) {
            $items = $this->itemService->getByBrandForOrder($brand, $order);

            $subTotalExclTax = $this->itemService->calculateSubTotalExclTax($items);

            $shippingFees = $this->shippingFeesCalculator->calculate($items, $brand->getShippingFees());

            $subTotalExclTax += $shippingFees;

            $vat = $brand->getVAT()->first();
            $totalInclTax = $subTotalExclTax + $subTotalExclTax * $vat->getRate() / 100;
        }

        $promotion = $this->promotionService->getOneByOrder($order);

        if (null !== $promotion) {
            $totalInclTax -= $promotion->getReduction();
        }

        return $totalInclTax;
    }
}
