<?php

declare(strict_types=1);

namespace App\Normalizer;

use Doctrine\DBAL\Exception\InvalidArgumentException as InvalidArgumentExceptionDBAL;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class DefaultErrorNormalizer
 *
 * @package App\Normalizer
 */
class DefaultErrorNormalizer implements NormalizerInterface
{
    /**
     * @var TranslatorInterface
     */
    private TranslatorInterface $translator;

    /**
     * DefaultErrorNormalizer constructor.
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
        return [
            'status' => false,
            'errors' => [
                'detail' => $this->translator->trans($object->getMessage()),
            ],
        ];
    }

    /**
     * @param mixed       $data
     * @param null|string $format
     *
     * @return bool
     */
    public function supportsNormalization($data, ?string $format = null): bool
    {
        return
            ($data instanceof \TypeError) ||
            ($data instanceof \InvalidArgumentException) ||
            ($data instanceof InvalidArgumentExceptionDBAL) ||
            ($data instanceof FlattenException) ||
            ($data instanceof \ErrorException) ||
            ($data instanceof \DomainException) ||
            ($data instanceof NotNormalizableValueException);
    }
}