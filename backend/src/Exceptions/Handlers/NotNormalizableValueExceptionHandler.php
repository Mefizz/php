<?php

declare(strict_types=1);

namespace App\Exceptions\Handlers;

use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;

/**
 * Class DomainErrorHandler
 * @package App\Exceptions\Handlers
 */
class NotNormalizableValueExceptionHandler
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * NotNormalizableValueExceptionHandler constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param NotNormalizableValueException $e
     */
    public function handle(NotNormalizableValueException $e): void
    {
        $this->logger->warning($e->getMessage(), ['exception' => $e]);
    }
}
