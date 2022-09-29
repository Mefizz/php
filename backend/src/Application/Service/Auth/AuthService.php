<?php

namespace App\Application\Service\Auth;

use Symfony\Component\Security\Core\User\UserInterface;

class AuthService extends AbstractAuthService
{
    public function authorize(UserInterface $account): array
    {
        return [
            'account_id' => $account->getId(),
            'email'      => $account->getEmail()->getValue(),
            'balance'    => $account->getBalance()->getValue(),
            'token'      => $this->getToken($account),
        ];
    }
}