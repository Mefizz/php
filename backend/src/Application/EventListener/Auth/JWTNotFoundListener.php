<?php

declare(strict_types=1);

namespace App\Application\EventListener\Auth;

use App\Application\Http\ApiResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTNotFoundEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

class JWTNotFoundListener
{
    public function __construct(private TranslatorInterface $translator)
    {
    }

    /**
     * @param JWTNotFoundEvent $event
     */
    public function onJWTNotFound(JWTNotFoundEvent $event)
    {
        $event->setResponse(
            new ApiResponse(
                [],
                false,
                $this->translator->trans('Missing token'),
                Response::HTTP_FORBIDDEN
            )
        );
    }
}