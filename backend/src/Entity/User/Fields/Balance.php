<?php

declare(strict_types=1);

namespace App\Entity\User\Fields;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Balance
{
    #[ORM\Column(type: "float", length: 100, nullable: false)]
    private float $balance;

    public function __construct(float $balance = 00.00)
    {
        $this->balance = $balance;
    }

    public function getValue(): float
    {
        return $this->balance;
    }
}