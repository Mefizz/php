<?php

namespace App\Application\Service\Auth;

use Gesdinet\JWTRefreshTokenBundle\Generator\RefreshTokenGeneratorInterface;
use Gesdinet\JWTRefreshTokenBundle\Model\RefreshTokenManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUser;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractAuthService
{
    public function __construct(
        private JWTTokenManagerInterface       $tokenManager,
        private RefreshTokenManagerInterface   $refreshTokenManager,
        private RefreshTokenGeneratorInterface $refreshTokenGenerator,
        private ValidatorInterface             $validator,
        public string                          $userIdentityField,
        public int                             $ttl
    )
    {
    }

    abstract public function authorize(UserInterface $account): array;

    public function getToken(UserInterface $account): string
    {
        $user = JWTUser::createFromPayload($account->getUserIdentifier(), ['roles' => $account->getRoles()]);

        return $this->tokenManager->create($user);
    }

    public function getRefreshToken(UserInterface $account): string
    {
        $datetime = new \DateTime();
        $datetime->modify('+' . $this->ttl . ' seconds');

        $refreshToken = $this->refreshTokenGenerator->createForUserWithTtl($account, $this->ttl);

        $accessor               = new PropertyAccessor();
        $userIdentityFieldValue = $accessor->getValue($account, $this->userIdentityField);

        $refreshToken->setUsername($userIdentityFieldValue);
        $refreshToken->setRefreshToken();
        $refreshToken->setValid($datetime);

        $valid = false;

        while (false === $valid) {
            $valid  = true;
            $errors = $this->validator->validate($refreshToken);

            if ($errors->count() > 0) {
                foreach ($errors as $error) {
                    if ('refreshToken' === $error->getPropertyPath()) {
                        $valid = false;
                        $refreshToken->setRefreshToken();
                    }
                }
            }
        }

        $this->refreshTokenManager->save($refreshToken);

        return $refreshToken->getRefreshToken();
    }
}