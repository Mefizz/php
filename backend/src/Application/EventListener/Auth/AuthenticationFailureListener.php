<?php

declare(strict_types=1);

namespace App\Application\EventListener\Auth;

use App\Application\Http\ApiResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

class AuthenticationFailureListener
{
    public function __construct(private TranslatorInterface $translator)
    {
    }

    public function onAuthenticationFailureResponse(AuthenticationFailureEvent $event)
    {
        $event->setResponse(
            new ApiResponse(
                [],
                false,
                $this->translator->trans('Bad credentials, please verify that your email/password are correctly set'),
                Response::HTTP_UNAUTHORIZED
            )
        );
    }

}