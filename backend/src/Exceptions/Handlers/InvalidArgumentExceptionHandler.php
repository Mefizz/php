<?php

declare(strict_types=1);

namespace App\Exceptions\Handlers;

use InvalidArgumentException;
use Psr\Log\LoggerInterface;

/**
 * Class DomainErrorHandler
 * @package App\Exceptions\Handlers
 */
class InvalidArgumentExceptionHandler
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * InvalidArgumentExceptionHandler constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param InvalidArgumentException $e
     */
    public function handle(InvalidArgumentException $e): void
    {
        $this->logger->warning($e->getMessage(), ['exception' => $e]);
    }
}
