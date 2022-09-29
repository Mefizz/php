<?php

declare(strict_types=1);


namespace App\Entity\Payment\Fields;

use Webmozart\Assert\Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Amount
{
    #[ORM\Column(type: "float", length: 100, nullable: false)]
    private float $value;

    public function __construct(float $value)
    {
        Assert::notEmpty($value);

        $this->value = $value;
    }

    public function getValue(): float
    {
        return $this->value;
    }
}