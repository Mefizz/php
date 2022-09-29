<?php

declare(strict_types=1);

namespace App\Application\EventListener\Auth;

use App\Application\Http\ApiResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTInvalidEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

class JWTInvalidListener
{
    public function __construct(private TranslatorInterface $translator)
    {
    }

    /**
     * @param JWTInvalidEvent $event
     */
    public function onJWTInvalid(JWTInvalidEvent $event)
    {
        $event->setResponse(
            new ApiResponse(
                [],
                false,
                $this->translator->trans('Your token is invalid, please login again to get a new one'),
                Response::HTTP_FORBIDDEN
            )
        );
    }

}