<?php

declare(strict_types=1);

namespace App\Entity\Token\Reset\Fields;

use DateInterval;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class ExpireAt
{
    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $value;

    private function __construct(DateTimeImmutable $value)
    {
        $this->value = $value;
    }

    public static function generate(DateInterval $interval): self
    {
        $now = new DateTimeImmutable();

        return new self($now->add($interval));
    }

    public function getValue(): DateTimeImmutable
    {
        return $this->value;
    }

    public function isEqual(self $value): bool
    {
        return $this->getValue() === $value->getValue();
    }
}