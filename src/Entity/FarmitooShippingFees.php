<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class FarmitooShippingFees extends ShippingFees
{
    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    private $slice;

    public function getSlice(): ?int
    {
        return $this->slice;
    }

    public function setSlice(int $slice): void
    {
        $this->slice = $slice;
    }
}
