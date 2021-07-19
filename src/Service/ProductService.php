<?php

namespace App\Service;

use Doctrine\Common\Collections\Collection;

class ProductService
{
    public function countFromItems(Collection $items): int
    {
        $count = 0;

        foreach ($items as $item) {
            $count += $item->getQuantity();
        }

        return $count;
    }
}
