<?php

namespace App\Controller;

use App\Cart\CartHandler;
use App\Entity\Order;
use App\Entity\OrderItem;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class CheckoutController extends AbstractController
{
    public function __construct(
        private CartHandler $cartService,
        private EntityManagerInterface $entityManager,
    ) {
    }

    #[Route('/checkout', name: 'app_checkout')]
    public function checkout(): Response
    {
        $cartItems = $this->cartService->getFullCart();

        if (empty($cartItems)) {
            $this->addFlash('warning', 'Your cart is empty.');
            return $this->redirectToRoute('app_cart');
        }

        return $this->render('checkout/index.html.twig', [
            'items' => $cartItems,
            'total' => $this->cartService->getTotal(),
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/checkout/process', name: 'app_checkout_process', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function process(Request $request): Response
    {
        $cartItems = $this->cartService->getFullCart();

        if (empty($cartItems)) {
            return $this->redirectToRoute('app_cart');
        }

        $addressId = $request->request->get('address_id');
        $cardId = $request->request->get('card_id');

        if (!$addressId || !$cardId) {
            $this->addFlash('error', 'Please select an address and a payment method.');
            return $this->redirectToRoute('app_checkout');
        }

        $address = $this->entityManager->getRepository(\App\Entity\Address::class)->find($addressId);
        $card = $this->entityManager->getRepository(\App\Entity\PaymentCard::class)->find($cardId);

        if (!$address || $address->getUser() !== $this->getUser() || !$card || $card->getUser() !== $this->getUser()) {
            $this->addFlash('error', 'Invalid address or payment method.');
            return $this->redirectToRoute('app_checkout');
        }

        $order = new Order();
        $order->setCustomer($this->getUser());
        $order->setReference('ER-' . strtoupper(bin2hex(random_bytes(4))));
        $order->setShippingAddress($address->getFullAddress());
        $order->setPaymentMethod($card->getDisplayString());

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
        $order->setStatus(Order::STATUS_PENDING);

        $this->entityManager->persist($order);
        $this->entityManager->flush();

        $this->cartService->clear();

        $this->addFlash('success', 'Order ' . $order->getReference() . ' placed successfully!');

        return $this->redirectToRoute('app_profile');
    }
}
