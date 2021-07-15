<?php

namespace App\Service;

use App\Entity\Order;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class VATService
{
    public function getForOrder(Order $order): Collection
    {
        $vats = new ArrayCollection();

        foreach ($order->getItems() as $item) {
            /**
             * On pourra le récupérer pour le pays
             * Pour l'instant, on récupère le premier (correspondant à FR)
             */
            $vat = $item->getProduct()->getBrand()->getVAT()->first();

            if (!$vats->contains($vat)) {
                $vats->add($vat);
            }
        }

        return $vats;
    }
}
