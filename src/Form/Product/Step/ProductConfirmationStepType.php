<?php

namespace App\Form\Product\Step;

use App\Form\Product\Step\Data\ProductFlowDto;
use App\Form\Product\Step\Data\Step\ConfirmationDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductConfirmationStepType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('confirmation', CheckboxType::class, [
            'label' => 'Validez vous le produit ?',
            'required' => false,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'label' => 'Confirmation',
            'help' => "S'il vous plait confirmer les informations du produit",
            'data_class' => ProductFlowDto::class,
            'inherit_data' => true,
        ]);
    }
}
