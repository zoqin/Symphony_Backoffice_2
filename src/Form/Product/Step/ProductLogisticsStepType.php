<?php

namespace App\Form\Product\Step;

use App\Form\Product\Step\Data\Step\PhysiqueDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductLogisticsStepType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('weight', NumberType::class, ['label' => 'Poids (kg)'])
            ->add('stock', IntegerType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'label' => 'Logistics',
            'help' => 'Renseignez les détails logistiques du produit physique',
            'data_class' => PhysiqueDto::class,
        ]);
    }
}
