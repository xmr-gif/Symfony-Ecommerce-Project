<?php

namespace App\Entity;

use App\Repository\PaymentCardRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaymentCardRepository::class)]
#[ORM\Table(name: 'payment_cards')]
class PaymentCard
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $cardholderName = null;

    #[ORM\Column(length: 20)]
    private ?string $maskedNumber = null; // e.g., **** **** **** 1234

    #[ORM\Column]
    private ?int $expiryMonth = null;

    #[ORM\Column]
    private ?int $expiryYear = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'paymentCards')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCardholderName(): ?string
    {
        return $this->cardholderName;
    }

    public function setCardholderName(string $cardholderName): static
    {
        $this->cardholderName = $cardholderName;

        return $this;
    }

    public function getMaskedNumber(): ?string
    {
        return $this->maskedNumber;
    }

    public function setMaskedNumber(string $maskedNumber): static
    {
        $this->maskedNumber = $maskedNumber;

        return $this;
    }

    public function getExpiryMonth(): ?int
    {
        return $this->expiryMonth;
    }

    public function setExpiryMonth(int $expiryMonth): static
    {
        $this->expiryMonth = $expiryMonth;

        return $this;
    }

    public function getExpiryYear(): ?int
    {
        return $this->expiryYear;
    }

    public function setExpiryYear(int $expiryYear): static
    {
        $this->expiryYear = $expiryYear;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getDisplayString(): string
    {
        return sprintf('%s (Exp: %02d/%d)', $this->maskedNumber, $this->expiryMonth, $this->expiryYear);
    }
}
