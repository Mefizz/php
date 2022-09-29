<?php

declare(strict_types=1);

namespace App\Exceptions\Handlers;

use TypeError;
use Psr\Log\LoggerInterface;

/**
 * Class TypeErrorHandler
 * @package App\Exceptions\Handlers
 */
class TypeErrorHandler
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * TypeErrorHandler constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param TypeError $e
     */
    public function handle(TypeError $e): void
    {
        $this->logger->warning($e->getMessage(), ['exception' => $e]);
    }
}
