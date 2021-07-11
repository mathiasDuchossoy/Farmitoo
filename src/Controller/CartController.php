<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use App\Service\PromotionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cart")
 */
class CartController extends AbstractController
{
    /**
     * @Route("/", name="cart_index", methods={"GET"})
     */
    public function index(OrderRepository $orderRepository, PromotionService $promotionService): Response
    {
        $order = $orderRepository->findOneBy([]);

        if (!$order) {
            throw $this->createNotFoundException('No order found');
        }

        return $this->render('cart/show.html.twig', [
            'order' => $order,
            'promotion' => $promotionService->getOneByOrder($order),
        ]);
    }
}
