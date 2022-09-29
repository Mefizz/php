<?php

declare(strict_types=1);

namespace App\Features\User\UseCase\Registration;

use App\Application\Http\DTO\BaseDataObject;
use Symfony\Component\Validator\Constraints as Assert;

final class Command implements BaseDataObject
{
    #[Assert\NotBlank]
    #[Assert\Email]
    public string $email;

    #[Assert\NotBlank]
    #[Assert\Length(['min' => 8])]
    public string $password;
}