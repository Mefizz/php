<?php

declare(strict_types=1);

namespace App\Exceptions\Handlers;

use App\Infrastructure\Exceptions\EntityNotFoundException;
use Psr\Log\LoggerInterface;

/**
 * Class EntityNotFoundExceptionHandler
 * @package App\Exceptions\Handlers
 */
class EntityNotFoundExceptionHandler
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * EntityNotFoundExceptionHandler constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param EntityNotFoundException $e
     */
    public function handle(EntityNotFoundException $e): void
    {
        $this->logger->warning($e->getMessage(), ['exception' => $e]);
    }
}
