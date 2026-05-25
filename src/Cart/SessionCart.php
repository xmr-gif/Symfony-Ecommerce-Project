<?php

namespace App\Cart;

use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Session-based cart storage strategy.
 * Implements CartStorageInterface by persisting cart data in the user's session.
 */
class SessionCart implements CartStorageInterface
{
    private const SESSION_KEY = 'cart';

    public function __construct(private readonly RequestStack $requestStack)
    {
    }

    public function add(int $productId, int $quantity = 1): void
    {
        $cart = $this->getContent();
        $cart[$productId] = ($cart[$productId] ?? 0) + $quantity;
        $this->save($cart);
    }

    public function decrement(int $productId): void
    {
        $cart = $this->getContent();

        if (!isset($cart[$productId])) {
            return;
        }

        if ($cart[$productId] > 1) {
            $cart[$productId]--;
        } else {
            unset($cart[$productId]);
        }

        $this->save($cart);
    }

    public function remove(int $productId): void
    {
        $cart = $this->getContent();
        unset($cart[$productId]);
        $this->save($cart);
    }

    public function clear(): void
    {
        $this->requestStack->getSession()->remove(self::SESSION_KEY);
    }

    /**
     * @return array<int, int>
     */
    public function getContent(): array
    {
        return $this->requestStack->getSession()->get(self::SESSION_KEY, []);
    }

    /**
     * @param array<int, int> $cart
     */
    private function save(array $cart): void
    {
        $this->requestStack->getSession()->set(self::SESSION_KEY, $cart);
    }
}
