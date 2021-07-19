<?php

namespace App\Service;

use App\Entity\Brand;
use App\Entity\Item;
use App\Entity\Order;
use Doctrine\Common\Collections\Collection;

class ItemService
{
    public function getByBrandForOrder(Brand $brand, Order $order): Collection
    {
        return $order->getItems()->filter(function (Item $item) use ($brand) {
            return $item->getProduct()->getBrand()->getId() === $brand->getId();
        });
    }

    /**
     * @param Collection|Item[] $items
     */
    public function calculateSubTotalExclTax(Collection $items): float
    {
        $subtotalExcludingTaxes = 0;

        foreach ($items as $item) {
            $subtotalExcludingTaxes += $item->getQuantity() * $item->getProduct()->getPrice();
        }

        return $subtotalExcludingTaxes;
    }
}
