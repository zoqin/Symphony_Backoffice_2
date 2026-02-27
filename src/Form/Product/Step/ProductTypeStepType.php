<?php

namespace App\Form\Product\Step;

use App\Form\Product\Step\Data\ProductFlowDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductTypeStepType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('type', ChoiceType::class, [
            'choices' => [
                'Produit Physique' => 'physique',
                'Produit Numérique' => 'numerique',
            ],
            'expanded' => true,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'label' => 'Type de produit',
            'help' => 'Renseignez le type de produit que vous voulez créer',
            'data_class' => ProductFlowDto::class,
            'inherit_data' => true,
        ]);
    }
}
