<?php

declare(strict_types=1);


namespace App\Features\User\Service;

use App\Entity\Token\Reset\ResetToken;
use App\Entity\User\User;
use App\Features\User\Repository\ResetTokenRepository;

class ResetTokenService
{
    public function __construct(public ResetTokenRepository $resetTokenRepository) {}

    public function findResetTokenByUser(User $user): ?ResetToken
    {
        return $this->resetTokenRepository->loadResetTokenByUser($user);
    }

    public function removeToken(ResetToken $resetToken): void
    {
       $this->resetTokenRepository->deleteToken($resetToken);
    }

    public function save(ResetToken $resetToken): void
    {
        $this->resetTokenRepository->save($resetToken);
    }
}