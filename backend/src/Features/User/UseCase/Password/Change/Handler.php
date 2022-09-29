<?php

declare(strict_types=1);

namespace App\Features\User\UseCase\Password\Change;

use App\Application\Service\Password\PasswordHasher;
use App\Entity\Token\Reset\Fields\Token;
use App\Entity\User\Fields\Password;
use App\Features\User\Service\ResetTokenService;
use DateTimeImmutable;
use Doctrine\ORM\NonUniqueResultException;
use DomainException;
use App\Application\Http\Validation\ValidationCheckerTrait;
use App\Features\User\Repository\UserRepository;
use App\Features\User\Service\UserService;

class Handler
{
    use ValidationCheckerTrait;

    public function __construct(
        public PasswordHasher    $passwordHasher,
        public UserRepository    $userRepository,
        public UserService       $userService,
        public ResetTokenService $resetTokenService
    )
    {
    }

    /**
     * @throws NonUniqueResultException
     */
    public function handle(Command $command): void
    {
        $user = $this->userService->get($command->email);

        if (!$resetToken = $this->resetTokenService->findResetTokenByUser($user)) {
            throw new DomainException('Code not found');
        }

        if (!$resetToken->validate(new Token($command->resetToken), new DateTimeImmutable())) {
            throw new DomainException('Code expired or invalid');
        }

        $user->changePassword(new Password($this->passwordHasher->hash($command->newPassword)));

        $this->userRepository->save($user);

        $this->resetTokenService->removeToken($resetToken);
    }
}