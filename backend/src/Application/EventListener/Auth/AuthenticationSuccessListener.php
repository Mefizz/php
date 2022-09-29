<?php

namespace App\Application\EventListener\Auth;

use DomainException;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class AuthenticationSuccessListener
{
    public function __construct(private TranslatorInterface $translator)
    {
    }

    /**
     * @param AuthenticationSuccessEvent $event
     *
     * @throws DomainException
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        if (!$user instanceof UserInterface) {
            return;
        }

        if (!$user->getStatus()->isActive()) {
            throw new DomainException('User not activated');
        }

        $event->setData(
            [
                'status' => true,
                'message' => $this->translator->trans('Login successful'),
                'data' => $data,
            ]
        );
    }

}