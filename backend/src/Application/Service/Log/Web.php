<?php

declare(strict_types=1);

namespace App\Application\Service\Log;

use Monolog\LogRecord;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Add extra data to logs.
 *
 * @see http://symfony.com/doc/current/logging/processors.html
 */
class Web
{
    public function __construct(public RequestStack $requestStack)
    {
    }

    /**
     * @param LogRecord $record
     *
     * @return LogRecord
     */
    public function processRecord(LogRecord $record): LogRecord
    {
        $record->extra['server'] = getHostByName(getHostName());

        if ($request = $this->requestStack->getCurrentRequest()) {
            $record->extra['host']   = $request->getHost();
            $record->extra['url']    = $request->getRequestUri();
            $record->extra['params'] = $request->request->all();
            $record->extra['ip']     = $request->getClientIp();
        }

        return $record;
    }
}