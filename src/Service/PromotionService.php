<?php

namespace App\Service;

use App\Entity\Order;
use App\Entity\Promotion;
use App\Repository\PromotionRepository;

class PromotionService
{
    /**
     * @var PromotionRepository
     */
    private $promotionRepository;

    public function __construct(PromotionRepository $promotionRepository)
    {
        $this->promotionRepository = $promotionRepository;
    }

    public function getOneByOrder(Order $order): ?Promotion
    {
        $promotion = $this->promotionRepository->findOneBy([]);

        if (null === $promotion) {
            return null;
        }

        if ($promotion->getMinAmount() > $order->getSubtotalExcludingTaxes()) {
            return null;
        }

        return $promotion;
    }
}
