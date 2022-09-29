<?php

declare(strict_types=1);

namespace App\Exceptions\Formatters;

use App\Exceptions\Handlers\EntityNotFoundExceptionHandler;
use App\Infrastructure\Exceptions\EntityNotFoundException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class EntityNotFoundExceptionFormatter
 * @package App\Exceptions\Formatters
 */
class EntityNotFoundExceptionFormatter implements EventSubscriberInterface
{
    /**
     * @var EntityNotFoundExceptionHandler
     */
    private EntityNotFoundExceptionHandler $handler;

    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * EntityNotFoundExceptionFormatter constructor.
     * @param EntityNotFoundExceptionHandler $handler
     * @param SerializerInterface $serializer
     */
    public function __construct(EntityNotFoundExceptionHandler $handler, SerializerInterface $serializer)
    {
        $this->handler = $handler;
        $this->serializer = $serializer;
    }

    /**
     * @return string[]
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
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

        if (!$exception instanceof EntityNotFoundException) {
            return;
        }

        $this->handler->handle($exception);

        $event->setResponse(new JsonResponse($this->serializer->serialize($exception, 'json'), 400, [], true));
    }
}