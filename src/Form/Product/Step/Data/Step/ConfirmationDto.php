<?php

namespace App\Form\Product\Step\Data\Step;

use Symfony\Component\Validator\Constraints as Assert;

class ConfirmationDto
{
    #[Assert\IsTrue(groups: ['confirmation'])]
    public ?bool $agree = null;
}
