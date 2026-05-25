<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Min;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Form for adding a product to the cart with a chosen quantity.
 * Used on the product detail page (etape02 requirement).
 */
class CartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantity', IntegerType::class, [
                'label' => 'Quantity',
                'data'  => 1,
                'attr'  => [
                    'min'   => 1,
                    'max'   => 99,
                    'class' => 'w-20 text-center bg-surface-container-low border border-outline-variant rounded-lg px-3 py-2 text-on-surface focus:outline-none focus:border-primary',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Please enter a quantity.']),
                    new Min(['value' => 1, 'message' => 'Quantity must be at least 1.']),
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Add to Cart',
                'attr'  => [
                    'class' => 'w-full bg-primary text-on-primary font-bold py-4 px-8 rounded-xl hover:bg-primary-dim transition-all duration-300',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
