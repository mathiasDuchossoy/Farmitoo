<?php

namespace App\Controller;

use App\Repository\VATRepository;
use App\Service\OrderService;
use App\Service\PromotionService;
use App\Service\ShippingFeesService;
use App\Service\VATService;
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
    public function show(
        OrderService $orderService,
        PromotionService $promotionService,
        ShippingFeesService $shippingFeesService,
        VATRepository $VATRepository
    ): Response
    {
        $order = $orderService->getOneOrFail();

        return $this->render('cart/show.html.twig', [
            'order' => $order,
            'promotion' => $promotionService->getOneByOrder($order),
            'shippingFees' => $shippingFeesService->calculateForOrder($order),
            'vats' => $VATRepository->findByOrder($order),
            'totalInclTax' => $orderService->calculateTotalInclTax($order),
        ]);
    }
}
