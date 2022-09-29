<?php

declare(strict_types=1);

namespace App\Features\User\Service;

use App\Features\User\Repository\UserRepository;
use App\Entity\User\User;
use Doctrine\ORM\NonUniqueResultException;
use DomainException;

class UserService
{

    public function __construct(public UserRepository $userRepository)
    {
    }

    /**
     * @throws NonUniqueResultException
     */
    public function find(string $email): ?User
    {
        return $this->userRepository->loadUserByIdentifier($email);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function get(string $email): User
    {
        if (!$user = $this->find($email)) {
            throw new DomainException('User not found');
        }

        return $user;
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findUserById(int $userId): ?User
    {
        return $this->userRepository->loadUserById($userId);
    }

}