<?php

declare(strict_types=1);

namespace App\Entity\Token\Reset\Fields;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
class Token
{
    #[ORM\Column(type: "string", nullable: false)]
    private string $value;

    public function __construct(string $value)
    {
        Assert::notEmpty($value);
        Assert::maxLength($value, 255, 'Token must not be longer than 255 characters');

        $this->value = $value;
    }

    public static function generate(): self
    {
        $resetToken = random_bytes(5);
        $resetToken = bin2hex($resetToken);
        $resetToken = substr($resetToken, -6);

        return new self($resetToken);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqual(self $value): bool
    {
        return $this->getValue() === $value->getValue();
    }
}