<?php

namespace App\Calculator;

use App\Entity\Brand;
use App\Entity\FarmitooShippingFees;
use App\Entity\GallagherShippingFees;
use App\Entity\Order;
use App\Entity\ShippingFees;
use App\Service\ItemService;
use App\Service\ProductService;
use Doctrine\Common\Collections\Collection;

class ShippingFeesCalculator
{
    /**
     * @var ProductService
     */
    private $productService;

    /**
     * @var ItemService
     */
    private $itemService;

    public function __construct(ProductService $productService, ItemService $itemService)
    {
        $this->productService = $productService;
        $this->itemService = $itemService;
    }

    public function calculate(Collection $items, ShippingFees $shippingFees): int
    {
        switch (get_class($shippingFees)) {
            case FarmitooShippingFees::class:
                return round($this->productService->countFromItems($items) / $shippingFees->getSlice()) * $shippingFees->getPrice();
            case GallagherShippingFees::class:
                return $shippingFees->getPrice();
            default:
                return 0;
        }
    }
}
