<?php

namespace App\Form\Product\Step\Data\Step;

use Symfony\Component\Validator\Constraints AS Assert;

class DetailsDto
{
    #[Assert\NotBlank(groups : ['details'])]
    #[Assert\Length(min: 1, max: 255)]
    public ?string $name = null;

    #[Assert\NotBlank(groups : ['details'])]
    public ?string $description = null;

    #[Assert\NotBlank(groups : ['details'])]
    public ?string $price = null;
}
