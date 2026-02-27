<?php

namespace App\Form\Product\Step\Data\Step;

use Symfony\Component\Validator\Constraints AS Assert;

class NumeriqueDto
{
    #[Assert\NotBlank(groups : ['numerique'])]
    public ?string $licenseKey = null;
}
