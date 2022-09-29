<?php

declare(strict_types=1);

namespace App\Exceptions\Formatters;

use App\Exceptions\Handlers\NotNormalizableValueExceptionHandler;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class NotNormalizableValueExceptionFormatter
 * @package App\Exceptions\Formatters
 */
class NotNormalizableValueExceptionFormatter implements EventSubscriberInterface
{
    /**
     * @var NotNormalizableValueExceptionHandler
     */
    private NotNormalizableValueExceptionHandler $handler;

    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * NotNormalizableValueExceptionFormatter constructor.
     * @param NotNormalizableValueExceptionHandler $handler
     * @param SerializerInterface $serializer
     */
    public function __construct(NotNormalizableValueExceptionHandler $handler, SerializerInterface $serializer)
    {
        $this->handler = $handler;
        $this->serializer = $serializer;
    }

    /**
     * @return string[]
     */
    public static function getSubscribedEvents(): array
    {
        return array(
            KernelEvents::EXCEPTION => 'onKernelException',
        );
    }

    /**
     * @param ExceptionEvent $event
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $request = $event->getRequest();

        if (strpos($request->getUri(), '/api/') === false) {
            return;
        }

        if (!$exception instanceof NotNormalizableValueException) {
            return;
        }

        $this->handler->handle($exception);

        $event->setResponse(new JsonResponse($this->serializer->serialize($exception, 'json'), 400, [], true));
    }
}