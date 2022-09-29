<?php

declare(strict_types=1);

namespace App\Entity\User\Fields;

use Webmozart\Assert\Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Email
{
    #[ORM\Column(type: "string", length: 50, nullable: false, unique: true)]
    private string $value;

    public function __construct(string $email)
    {
        Assert::notEmpty($email);
        Assert::email($email);
        Assert::maxLength($email, 50, 'Email must not be longer than 50 characters');

        $this->value = $email;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqual(self $email): bool
    {
        return $this->getValue() === $email->getValue();
    }
}