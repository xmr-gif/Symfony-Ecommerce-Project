<?php

namespace App\Cart;

/**
 * Defines the contract for any cart storage strategy.
 * Following the Open/Closed Principle (SOLID), new storage strategies
 * (e.g., DatabaseCart, RedisCart) can be added without modifying existing code.
 */
interface CartStorageInterface
{
    /**
     * Add or increment a product in the cart.
     */
    public function add(int $productId, int $quantity = 1): void;

    /**
     * Decrement a product's quantity, removing it if quantity reaches 0.
     */
    public function decrement(int $productId): void;

    /**
     * Completely remove a product from the cart.
     */
    public function remove(int $productId): void;

    /**
     * Clear all items from the cart.
     */
    public function clear(): void;

    /**
     * Retrieve the raw cart data as an associative array [productId => quantity].
     *
     * @return array<int, int>
     */
    public function getContent(): array;
}
