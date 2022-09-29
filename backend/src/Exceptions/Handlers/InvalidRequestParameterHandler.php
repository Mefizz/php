<?php

declare(strict_types=1);

namespace App\Exceptions\Handlers;

use App\Infrastructure\Exceptions\InvalidRequestParameter;
use Psr\Log\LoggerInterface;

/**
 * Class DomainErrorHandler
 *
 * @package App\Exceptions\Handlers
 */
class InvalidRequestParameterHandler
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * InvalidRequestParameterHandler constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param InvalidRequestParameter $e
     */
    public function handle(InvalidRequestParameter $e): void
    {
        $this->logger->warning($e->getMessage(), ['exception' => $e]);
    }
}
