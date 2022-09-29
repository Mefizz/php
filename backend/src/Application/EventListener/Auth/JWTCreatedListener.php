<?php

namespace App\Application\EventListener\Auth;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JWTCreatedListener
{
    /**
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $payload = $event->getData();

        $event->setData($payload);

        $header = $event->getHeader();
        $event->setHeader($header);
    }
}