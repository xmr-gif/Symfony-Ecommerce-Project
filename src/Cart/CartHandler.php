<?php

namespace App\Cart;

use App\Repository\ProductRepository;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

/**
 * CartHandler orchestrates cart operations by delegating to a storage strategy.
 * This follows the Strategy Pattern and Single Responsibility Principle (SOLID).
 *
 * The CartHandler does not care HOW the cart is stored - it delegates entirely
 * to whichever CartStorageInterface implementation is injected (e.g. SessionCart).
 *
 * The #[Autowire] attribute specifies which concrete implementation to use.
 * To switch to ApiCart, simply change the service reference below.
 */
class CartHandler
{
    public function __construct(
        #[Autowire(service: 'App\Cart\SessionCart')]
        private readonly CartStorageInterface $storage,
        private readonly ProductRepository $productRepository,
    ) {
    }

    /**
     * Add a product to the cart with a given quantity.
     */
    public function add(int $productId, int $quantity = 1): void
    {
        $this->storage->add($productId, $quantity);
    }

    /**
     * Decrement a product's quantity by one.
     */
    public function decrement(int $productId): void
    {
        $this->storage->decrement($productId);
    }

    /**
     * Remove a product entirely from the cart.
     */
    public function remove(int $productId): void
    {
        $this->storage->remove($productId);
    }

    /**
     * Clear the entire cart.
     */
    public function clear(): void
    {
        $this->storage->clear();
    }

    /**
     * Returns enriched cart items: each item contains the Product entity and quantity.
     *
     * @return array<int, array{product: \App\Entity\Product, quantity: int}>
     */
    public function getFullCart(): array
    {
        $cartData = [];

        foreach ($this->storage->getContent() as $productId => $quantity) {
            $product = $this->productRepository->find($productId);

            if (!$product) {
                // Product was deleted from the catalog — clean it up
                $this->storage->remove($productId);
                continue;
            }

            $cartData[] = [
                'product'  => $product,
                'quantity' => $quantity,
            ];
        }

        return $cartData;
    }

    /**
     * Calculates the total price of all items in the cart.
     */
    public function getTotal(): float
    {
        $total = 0.0;

        foreach ($this->getFullCart() as $item) {
            $total += $item['product']->getPrice() * $item['quantity'];
        }

        return $total;
    }

    /**
     * Returns the total number of items (sum of all quantities) in the cart.
     */
    public function getTotalQuantity(): int
    {
        return array_sum($this->storage->getContent());
    }
}
