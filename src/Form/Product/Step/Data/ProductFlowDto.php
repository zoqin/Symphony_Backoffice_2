<?php

namespace App\Form\Product\Step\Data;

use App\Form\Product\Step\Data\Step\ConfirmationDto;
use App\Form\Product\Step\Data\Step\DetailsDto;
use App\Form\Product\Step\Data\Step\NumeriqueDto;
use App\Form\Product\Step\Data\Step\PhysiqueDto;

use Symfony\Component\Validator\Constraints AS Assert;

class ProductFlowDto
{
    public string $currentStep = 'type';

    // step 1 : type
    #[Assert\NotBlank(groups : ['type'])]
    public ?string $type = null;

    // step 2 : details
    #[Assert\Valid(groups : ['details'])]
    public ?DetailsDto $details = null;

    // step 3 : physique
    #[Assert\Valid(groups : ['physique'])]
    public ?PhysiqueDto $physique = null;

    // step 4 : numerique
    #[Assert\Valid(groups : ['numerique'])]
    public ?NumeriqueDto $numerique = null;

    // step 5 : confirmation
    #[Assert\NotBlank(groups : ['confirmation'])]
    #[Assert\IsTrue(groups: ['confirmation'])]
    public ?bool $confirmation = null;

}
