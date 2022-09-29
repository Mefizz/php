<?php

namespace App\Application\EventListener\Auth;

use Gesdinet\JWTRefreshTokenBundle\EventListener\AttachRefreshTokenOnSuccessListener as AttachRefreshTokenOnSuccessListenerBasr;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;

class AttachRefreshTokenOnSuccessListener extends AttachRefreshTokenOnSuccessListenerBasr
{
    public function attachRefreshToken(AuthenticationSuccessEvent $event): void
    {
        parent::attachRefreshToken($event);

        $data = $event->getData();

        $valueRefreshToken = $data[$this->tokenParameterName];
        unset($data[$this->tokenParameterName]);
        $data['data'][$this->tokenParameterName] = $valueRefreshToken;

        $event->setData($data);
    }
}
