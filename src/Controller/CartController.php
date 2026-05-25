<?php

namespace App\Controller;

use App\Cart\CartHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    public function __construct(private CartHandler $cartService)
    {
    }

    #[Route('/cart', name: 'app_cart')]
    public function index(): Response
    {
        return $this->render('cart/index.html.twig', [
            'items' => $this->cartService->getFullCart(),
            'total' => $this->cartService->getTotal(),
        ]);
    }

    #[Route('/cart/add/{id}', name: 'app_cart_add')]
    public function add(int $id): Response
    {
        $this->cartService->add($id);

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/remove/{id}', name: 'app_cart_remove')]
    public function remove(int $id): Response
    {
        $this->cartService->remove($id);

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/decrement/{id}', name: 'app_cart_decrement')]
    public function decrement(int $id): Response
    {
        $this->cartService->decrement($id);

        return $this->redirectToRoute('app_cart');
    }
}
