<?php

namespace App\Application\Http\Validation;

use App\Infrastructure\Exceptions\InvalidRequestData;
use Symfony\Contracts\Service\Attribute\Required;
use Symfony\Component\Validator\Validator\ValidatorInterface;

trait ValidationCheckerTrait
{
    public ValidatorInterface $validator;

    #[Required]
    public function setValidator(ValidatorInterface $validator): void
    {
        $this->validator = $validator;
    }

    /**
     * @throws InvalidRequestData
     */
    public function validate($dto)
    {
        $errors = $this->validator->validate($dto);

        if (0 !== count($errors)) {
            throw new InvalidRequestData($errors);
        }
    }
}