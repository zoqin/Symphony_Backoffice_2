<?php

namespace App\Form\Product\Step\Data\Step;

use Symfony\Component\Validator\Constraints AS Assert;

class PhysiqueDto
{
    #[Assert\NotBlank(groups : ['physique'])]
    public ?int $weight = null;

    #[Assert\NotBlank(groups : ['physique'])]
    public ?int $stock = null;
}
