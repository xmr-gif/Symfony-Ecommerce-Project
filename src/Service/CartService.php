<?php

namespace App\Service;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class CartService
{
    public function __construct(
        private RequestStack $requestStack,
        private ProductRepository $productRepository
    ) {
    }

    public function add(int $id): void
    {
        $session = $this->requestStack->getSession();
        $cart = $session->get('cart', []);

        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        $session->set('cart', $cart);
    }

    public function decrement(int $id): void
    {
        $session = $this->requestStack->getSession();
        $cart = $session->get('cart', []);

        if (!empty($cart[$id])) {
            if ($cart[$id] > 1) {
                $cart[$id]--;
            } else {
                unset($cart[$id]);
            }
        }

        $session->set('cart', $cart);
    }

    public function remove(int $id): void
    {
        $session = $this->requestStack->getSession();
        $cart = $session->get('cart', []);

        if (!empty($cart[$id])) {
            unset($cart[$id]);
        }

        $session->set('cart', $cart);
    }

    public function clear(): void
    {
        $this->requestStack->getSession()->remove('cart');
    }

    public function getFullCart(): array
    {
        $session = $this->requestStack->getSession();
        $cart = $session->get('cart', []);
        
        $cartData = [];
        
        foreach ($cart as $id => $quantity) {
            $product = $this->productRepository->find($id);
            if (!$product) {
                // If product was deleted, remove it from cart
                $this->remove($id);
                continue;
            }
            
            $cartData[] = [
                'product' => $product,
                'quantity' => $quantity,
            ];
        }
        
        return $cartData;
    }

    public function getTotal(): float
    {
        $total = 0;
        foreach ($this->getFullCart() as $item) {
            $total += $item['product']->getPrice() * $item['quantity'];
        }
        
        return $total;
    }
    
    public function getTotalQuantity(): int
    {
        $session = $this->requestStack->getSession();
        $cart = $session->get('cart', []);
        
        return array_sum($cart);
    }
}
