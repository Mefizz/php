<?php

namespace App\Entity\User;

use App\Entity\User\Fields\{Balance, Email, Password};
use DateTimeImmutable;
use JsonSerializable;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Features\User\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: "`user_users`")]
class User implements UserInterface, PasswordAuthenticatedUserInterface, JsonSerializable
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Embedded(class: Email::class)]
    private Email $email;

    #[ORM\Embedded(class: Balance::class)]
    private Balance $balance;

    #[ORM\Embedded(class: Password::class)]
    private Password $password;

    public function __construct(
        Email             $email,
        Password          $password,
        Balance           $balance

    )
    {
        $this->email            = $email;
        $this->password         = $password;
        $this->balance          = $balance;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Email
     */
    public function getEmail(): Email
    {
        return $this->email;
    }

    /**
     * @return Balance
     */
    public function getBalance(): Balance
    {
        return $this->balance;
    }

    public function getPassword(): string
    {
        return $this->password->getValue();
    }

    public function getUserIdentifier(): string
    {
        return $this->email->getValue();
    }

    public function changeLastAccess(): void
    {
        $this->lastAccess = new DateTimeImmutable();
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function eraseCredentials()
    {

    }

    public function jsonSerialize(): array
    {
        return [
            "id"         => $this->getId(),
            "email"      => $this->getEmail()->getValue(),
            "balance" => $this->getBalance()->getValue()
        ];
    }
}
