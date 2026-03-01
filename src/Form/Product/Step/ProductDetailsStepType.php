<?php

namespace App\Form\Product\Step;

use App\Form\Product\Step\Data\Step\DetailsDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductDetailsStepType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description', TextareaType::class)
            ->add('price', MoneyType::class, [
                'label' => 'Prix ',
                'currency' => 'EUR',
                'divisor' => 1
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'label' => 'Detailes',
            'help' => 'Veuillez renseigner les détails du produit',
            'data_class' => DetailsDto::class
        ]);
    }
}
