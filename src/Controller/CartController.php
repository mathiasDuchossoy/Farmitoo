<?php

namespace App\Controller;

use App\Service\OrderService;
use App\Service\PromotionService;
use App\Service\ShippingFeesService;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cart")
 */
class CartController extends AbstractController
{
    /**
     * @Route("/", name="cart_show", methods={"GET"})
     * @throws EntityNotFoundException
     */
    public function show(OrderService $orderService, PromotionService $promotionService, ShippingFeesService $shippingFeesService): Response
    {
        $order = $orderService->getOneOrFail();

        return $this->render('cart/show.html.twig', [
            'order' => $order,
            'promotion' => $promotionService->getOneByOrder($order),
            '$shippingFees' => $shippingFeesService->calculate($order),
        ]);
    }
}
