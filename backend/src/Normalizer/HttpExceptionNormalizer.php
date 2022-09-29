<?php

declare(strict_types=1);

namespace App\Normalizer;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class HttpExceptionNormalizer
 *
 * @package App\Normalizer
 */
class HttpExceptionNormalizer implements NormalizerInterface
{
    /**
     * @var TranslatorInterface
     */
    private TranslatorInterface $translator;

    /**
     * HttpExceptionNormalizer constructor.
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
        return $data instanceof HttpException;
    }
}