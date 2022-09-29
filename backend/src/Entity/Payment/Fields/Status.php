<?php

declare(strict_types=1);

namespace App\Entity\Payment\Fields;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
class Status
{
    const ITEMS = [
        'OK'  => 10,
        'MEH' => 0,
    ];

    #[ORM\Column(type: "smallint", nullable: false)]
    private int $value;

    public function __construct(int $value)
    {
        Assert::oneOf($value, self::ITEMS);

        $this->value = $value;
    }

    public function isEqual(self $value): bool
    {
        return $this->getValue() === $value->getValue();
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }
}