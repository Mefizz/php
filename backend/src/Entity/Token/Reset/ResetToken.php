<?php

declare(strict_types=1);

namespace App\Entity\Token\Reset;

use App\Application\Service\Traits\Timestamps;
use App\Entity\Token\Reset\Fields\ExpireAt;
use App\Entity\Token\Reset\Fields\Token;
use App\Entity\User\User;
use App\Features\User\Repository\ResetTokenRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: ResetTokenRepository::class)]
#[ORM\Table(name: "`user_reset_tokens`")]
class ResetToken
{
    use Timestamps;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Embedded]
    private Token $token;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private User $user;

    #[ORM\Embedded]
    private ExpireAt $expireAt;

    public function __construct(
        Token    $token,
        User     $user,
        ExpireAt $expireAt
    )
    {
        $this->user     = $user;
        $this->token    = $token;
        $this->expireAt = $expireAt;
        $this->createdAt();
    }

    public function changeToken(Token $token, ExpireAt $expireAt): void
    {
        $this->token    = $token;
        $this->expireAt = $expireAt;

        $this->updatedAt();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getToken(): Token
    {
        return $this->token;
    }

    public function getExpireAt(): ExpireAt
    {
        return $this->expireAt;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function validate(Token $token, DateTimeImmutable $now): bool
    {
        return $this->getToken()->isEqual($token) && $this->expireAt->getValue() >= $now;
    }
}