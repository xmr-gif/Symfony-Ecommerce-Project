<?php

namespace App\Controller;

use App\Form\ProfileType;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
class ProfileController extends AbstractController
{
    public function __construct(
        private OrderRepository $orderRepository,
        private EntityManagerInterface $entityManager,
    ) {
    }

    #[Route('/profile', name: 'app_profile')]
    public function index(): Response
    {
        $user = $this->getUser();
        $orders = $this->orderRepository->findByCustomer($user);

        return $this->render('profile/index.html.twig', [
            'user' => $user,
            'orders' => $orders,
        ]);
    }

    #[Route('/profile/edit', name: 'app_profile_edit')]
    public function edit(Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', 'Profile updated successfully.');

            return $this->redirectToRoute('app_profile');
        }

        return $this->render('profile/edit.html.twig', [
            'form' => $form,
            'user' => $user,
        ]);
    }
    #[Route('/profile/address/add', name: 'app_profile_add_address')]
    public function addAddress(Request $request): Response
    {
        $address = new \App\Entity\Address();
        $form = $this->createForm(\App\Form\AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $address->setUser($this->getUser());
            $this->entityManager->persist($address);
            $this->entityManager->flush();

            $this->addFlash('success', 'Address added successfully.');
            return $this->redirectToRoute('app_checkout');
        }

        return $this->render('profile/add_address.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/profile/card/add', name: 'app_profile_add_card')]
    public function addCard(Request $request): Response
    {
        $card = new \App\Entity\PaymentCard();
        $form = $this->createForm(\App\Form\PaymentCardType::class, $card);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Mask the card number (just keep last 4)
            $rawNumber = $card->getMaskedNumber();
            $card->setMaskedNumber('**** **** **** ' . substr($rawNumber, -4));
            
            $card->setUser($this->getUser());
            $this->entityManager->persist($card);
            $this->entityManager->flush();

            $this->addFlash('success', 'Payment card added successfully.');
            return $this->redirectToRoute('app_checkout');
        }

        return $this->render('profile/add_card.html.twig', [
            'form' => $form,
        ]);
    }
}
