<?php

declare(strict_types=1);

namespace App\Exceptions\Handlers;

use App\Infrastructure\Exceptions\InvalidRequestData;
use Psr\Log\LoggerInterface;

/**
 * Class DomainErrorHandler
 * @package App\Exceptions\Handlers
 */
class InvalidRequestDataHandler
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * InvalidRequestDataHandler constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param InvalidRequestData $e
     */
    public function handle(InvalidRequestData $e): void
    {
        $this->logger->warning($e->getMessage(), ['exception' => $e]);
    }
}
