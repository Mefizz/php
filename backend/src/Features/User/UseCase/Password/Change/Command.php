<?php

declare(strict_types=1);

namespace App\Features\User\UseCase\Password\Change;

use App\Application\Http\DTO\BaseDataObject;
use Symfony\Component\Validator\Constraints as Assert;

final class Command implements BaseDataObject
{
    #[Assert\NotBlank(message: 'cannot be empty')]
    #[Assert\Email]
    public string $email;

    #[Assert\NotBlank(message: 'cannot be empty')]
    public string $resetToken;

    #[Assert\NotBlank(message: 'cannot be empty')]
    #[Assert\Length(min: 8)]
    public string $newPassword;
}