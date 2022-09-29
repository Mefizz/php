<?php

declare(strict_types=1);

namespace App\Entity\User\Fields;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Password
{
    #[ORM\Column(type: "string", nullable: false)]
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function isEqual(self $value): bool
    {
        return $this->value === $value->getValue();
    }

    public function getValue(): string
    {
        return $this->value;
    }
}