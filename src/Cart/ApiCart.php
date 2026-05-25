<?php

namespace App\Cart;

/**
 * API-based cart storage strategy.
 * Simulates cart manipulation through an external API.
 *
 * This class exists to demonstrate SOLID compliance (Open/Closed Principle):
 * Adding a new storage strategy does NOT require modifying CartHandler.
 * As required by etape03, dd() calls are used to simulate API operations.
 */
class ApiCart implements CartStorageInterface
{
    public function add(int $productId, int $quantity = 1): void
    {
        // Simulates an API call to add a product to the remote cart
        dd('ApiCart::add() called', [
            'productId' => $productId,
            'quantity'  => $quantity,
            'action'    => 'POST /api/cart/items',
        ]);
    }

    public function decrement(int $productId): void
    {
        // Simulates an API call to decrement a product's quantity
        dd('ApiCart::decrement() called', [
            'productId' => $productId,
            'action'    => 'PATCH /api/cart/items/' . $productId,
        ]);
    }

    public function remove(int $productId): void
    {
        // Simulates an API call to remove a product from the cart
        dd('ApiCart::remove() called', [
            'productId' => $productId,
            'action'    => 'DELETE /api/cart/items/' . $productId,
        ]);
    }

    public function clear(): void
    {
        // Simulates an API call to clear the entire cart
        dd('ApiCart::clear() called', [
            'action' => 'DELETE /api/cart',
        ]);
    }

    /**
     * @return array<int, int>
     */
    public function getContent(): array
    {
        // Simulates an API call to retrieve cart content
        dd('ApiCart::getContent() called', [
            'action' => 'GET /api/cart',
        ]);

        return []; // Unreachable, but satisfies the return type
    }
}
