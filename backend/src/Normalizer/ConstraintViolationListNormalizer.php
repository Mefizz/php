<?php

declare(strict_types=1);

namespace App\Normalizer;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class ConstraintViolationListNormalizer
 *
 * @package App\Normalizer
 */
class ConstraintViolationListNormalizer implements NormalizerInterface
{
    /**
     * @var TranslatorInterface
     */
    private TranslatorInterface $translator;

    /**
     * ConstraintViolationListNormalizer constructor.
     *
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @param mixed       $object
     * @param null|string $format
     * @param array       $context
     *
     * @return array
     */
    public function normalize($object, ?string $format = null, array $context = []): array
    {
        /**
         * @var ConstraintViolationListInterface $object
         */
        [$message, $violations] = $this->getMessageAndViolations($object);

        return [
            'status' => false,
            'errors' => [
                'detail' => $message ?: $this->translator->trans('Unknown error. Contact support please.'),
                'violations' => $violations,
            ],
        ];
    }

    /**
     * @param ConstraintViolationListInterface $constraintViolationList
     *
     * @return array
     */
    private function getMessageAndViolations(ConstraintViolationListInterface $constraintViolationList): array
    {
        $violations = [];
        $message = '';

        /** @var ConstraintViolation $violation */
        foreach ($constraintViolationList as $violation) {
            $propertyPath = $violation->getPropertyPath();
            $violationMessage = $violation->getMessage();

            $violations[] = [
                'propertyPath' => $propertyPath,
                'message' => $violationMessage,
            ];

            if ($propertyPath) {
                $propertyPath = $this->translator->trans(ucfirst($propertyPath));
                $message = sprintf('%s: %s', $propertyPath, $violationMessage);
            } else {
                $message = $violationMessage;
            }

            return [$message, $violations];
        }

        return [$message, $violations];
    }

    /**
     * @param mixed       $data
     * @param null|string $format
     *
     * @return bool
     */
    public function supportsNormalization($data, ?string $format = null): bool
    {
        return $data instanceof ConstraintViolationListInterface;
    }
}
