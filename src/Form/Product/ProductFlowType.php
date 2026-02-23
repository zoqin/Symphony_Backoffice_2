<?php

namespace App\Form\Product;

use App\Entity\Product;
use Symfony\Component\Form\Flow\AbstractFlowType;
use App\Form\Product\Step\ProductTypeStepType;
use App\Form\Product\Step\ProductDetailsStepType;
use App\Form\Product\Step\ProductLogisticsStepType;
use App\Form\Product\Step\ProductLicenseStepType;
use Symfony\Component\Form\Flow\Type\NavigatorFlowType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductFlowType extends AbstractFlowType
{
    public function buildFormFlow(FormFlowBuilderInterface $builder, array $options): void
    {
        $builder->addStep('type', ProductTypeStepType::class);
        $builder->addStep('details', ProductDetailsStepType::class);
        $builder->addStep('physique', ProductLogisticsStepType::class);
        $builder->addStep('numerique', ProductLicenseStepType::class);

        $builder->add('navigator', NavigatorFlowType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
            'step_property_path' => 'currentStep',
        ]);
    }
}
