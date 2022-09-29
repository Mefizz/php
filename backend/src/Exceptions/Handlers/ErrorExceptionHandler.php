<?php

declare(strict_types=1);

namespace App\Exceptions\Handlers;

use ErrorException;
use Psr\Log\LoggerInterface;

/**
 * Class ErrorExceptionHandler
 * @package App\Exceptions\Handlers
 */
class ErrorExceptionHandler
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * ErrorExceptionHandler constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param ErrorException $e
     */
    public function handle(ErrorException $e): void
    {
        $this->logger->warning($e->getMessage(), ['exception' => $e]);
    }
}
