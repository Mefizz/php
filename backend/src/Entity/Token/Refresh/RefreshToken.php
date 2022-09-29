<?php

declare(strict_types=1);

namespace App\Entity\Token\Refresh;

use Doctrine\ORM\Mapping as ORM;
use Gesdinet\JWTRefreshTokenBundle\Entity\RefreshTokenRepository;
use Gesdinet\JWTRefreshTokenBundle\Entity\RefreshToken as BaseRefreshToken;

#[ORM\Entity(repositoryClass: RefreshTokenRepository::class)]
#[ORM\Table(name: "`user_refresh_tokens`")]
class RefreshToken extends BaseRefreshToken
{
}
