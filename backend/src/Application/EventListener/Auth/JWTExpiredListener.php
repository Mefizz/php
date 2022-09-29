<?php

declare(strict_types=1);

namespace App\Application\EventListener\Auth;

use App\Application\Http\ApiResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTExpiredEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

class JWTExpiredListener
{
    public function __construct(private TranslatorInterface $translator)
    {
    }

    /**
     * @param JWTExpiredEvent $event
     */
    public function onJWTExpired(JWTExpiredEvent $event)
    {
        $event->setResponse(
            new ApiResponse(
                [],
                false,
                $this->translator->trans('Your token is expired, please renew it'),
                Response::HTTP_UNAUTHORIZED,
            )
        );
    }

}