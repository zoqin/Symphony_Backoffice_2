<?php

namespace App\Form\Product\Step;

use App\Form\Product\Step\Data\Step\NumeriqueDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductLicenseStepType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('licenseKey', TextType::class, ['label' => 'Clé de licence/ Accès']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'label' => 'License',
            'help' => 'Renseignez la licence du produit numérique',
            'data_class' => NumeriqueDto::class,
        ]);
    }
}
