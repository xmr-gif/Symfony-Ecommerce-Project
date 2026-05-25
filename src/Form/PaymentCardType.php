<?php

namespace App\Form;

use App\Entity\PaymentCard;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaymentCardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[sprintf('%02d', $i)] = $i;
        }

        $years = [];
        $currentYear = (int) date('Y');
        for ($i = 0; $i <= 10; $i++) {
            $years[$currentYear + $i] = $currentYear + $i;
        }

        $builder
            ->add('cardholderName', TextType::class)
            ->add('maskedNumber', TextType::class, [
                'label' => 'Card Number (Mock)',
                'attr' => ['placeholder' => '1234 5678 9101 1121']
            ])
            ->add('expiryMonth', ChoiceType::class, [
                'choices' => $months
            ])
            ->add('expiryYear', ChoiceType::class, [
                'choices' => $years
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PaymentCard::class,
        ]);
    }
}
