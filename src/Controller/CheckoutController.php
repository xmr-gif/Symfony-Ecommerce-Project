<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Service\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class CheckoutController extends AbstractController
{
    public function __construct(
        private CartService $cartService,
        private EntityManagerInterface $entityManager,
    ) {
    }

    #[Route('/checkout', name: 'app_checkout')]
    #[IsGranted('ROLE_USER')]
    public function checkout(): Response
    {
        $cartItems = $this->cartService->getFullCart();

        if (empty($cartItems)) {
            $this->addFlash('warning', 'Your cart is empty.');

            return $this->redirectToRoute('app_cart');
        }

        $order = new Order();
        $order->setCustomer($this->getUser());
        $order->setReference('ER-' . strtoupper(bin2hex(random_bytes(4))));

        $total = 0;

        foreach ($cartItems as $item) {
            $orderItem = new OrderItem();
            $orderItem->setProduct($item['product']);
            $orderItem->setQuantity($item['quantity']);
            $orderItem->setUnitPrice($item['product']->getPrice());

            $order->addItem($orderItem);
            $total += $orderItem->getLineTotal();
        }

        $order->setTotalAmount((string) $total);
        $order->setStatus(Order::STATUS_DISPATCHED);

        $this->entityManager->persist($order);
        $this->entityManager->flush();

        $this->cartService->clear();

        $this->addFlash('success', 'Order ' . $order->getReference() . ' placed successfully!');

        return $this->redirectToRoute('app_profile');
    }
}
