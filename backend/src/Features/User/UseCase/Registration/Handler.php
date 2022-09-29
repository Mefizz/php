<?php

declare(strict_types=1);

namespace App\Features\User\UseCase\Registration;

use App\Application\Service\Password\PasswordHasher;
use App\Entity\User\Fields\{Balance, Email, Password};
use App\Features\User\Repository\UserRepository;
use App\Entity\User\User;
use Doctrine\ORM\NonUniqueResultException;
use DomainException;

class Handler
{
    public function __construct(
        private PasswordHasher $passwordHasher,
        private UserRepository $userRepository
    )
    {
    }

    /**
     * @throws NonUniqueResultException
     */
    public function handle(Command $command): User
    {
        if ($this->userRepository->findUserByEmail($command->email)) {
            throw new DomainException('User with this email already exists');
        }

        $user = new User(
            new Email($command->email),
            new Password($this->passwordHasher->hash($command->password)),
            new Balance()
        );

        $this->userRepository->save($user);

        return $user;
    }
}