<?php

namespace App\Calculator;

use App\Entity\Brand;
use App\Entity\FarmitooShippingFees;
use App\Entity\GallagherShippingFees;
use App\Entity\Item;
use Doctrine\Common\Collections\Collection;

class ShippingFeesCalculator
{
    /**
     * @param Item[]|Collection $items
     */
    public function calculate(Collection $items, Brand $brand): int
    {
        $shippingFees = $brand->getShippingFees();

        switch (get_class($shippingFees)) {
            case FarmitooShippingFees::class:
                return round($this->countItems($items) / $shippingFees->getSlice()) * $shippingFees->getPrice();
            case GallagherShippingFees::class:
                return $shippingFees->getPrice();
            default:
                return 0;
        }
    }

    private function countItems(Collection $items): int
    {
        $count = 0;

        foreach ($items as $item) {
            $count += $item->getQuantity();
        }

        return $count;
    }
}
