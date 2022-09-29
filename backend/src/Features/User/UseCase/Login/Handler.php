<?php

namespace App\Features\User\UseCase\Login;

use App\Application\Service\Auth\AuthService;
use App\Application\Service\Password\PasswordHasher;
use App\Features\User\Service\UserService;
use Doctrine\ORM\NonUniqueResultException;
use DomainException;

class Handler
{
    public function __construct(
        private PasswordHasher $passwordHasher,
        private AuthService    $authService,
        private UserService    $userService
    )
    {
    }

    /**
     * @throws NonUniqueResultException
     */
    public function handle(Command $command): array
    {

        $user = $this->userService->find($command->email);

        if (!$user || !$this->passwordHasher->validate($command->password, $user->getPassword())) {
            throw new DomainException('Bad credentials, please verify that your email/password are correctly set');
        }

        $user->changeLastAccess();

        return $this->authService->authorize($user);
    }


}