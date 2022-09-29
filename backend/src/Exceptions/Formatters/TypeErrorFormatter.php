<?php

declare(strict_types=1);

namespace App\Exceptions\Formatters;

use App\Exceptions\Handlers\TypeErrorHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use TypeError;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class TypeErrorFormatter
 * @package App\Exceptions\Formatters
 */
class TypeErrorFormatter implements EventSubscriberInterface
{
    /**
     * @var TypeErrorHandler
     */
    private TypeErrorHandler $handler;

    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * TypeErrorFormatter constructor.
     * @param TypeErrorHandler $handler
     * @param SerializerInterface $serializer
     */
    public function __construct(TypeErrorHandler $handler, SerializerInterface $serializer)
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

        if (!$exception instanceof TypeError) {
            return;
        }

        $this->handler->handle($exception);

        $event->setResponse(new JsonResponse($this->serializer->serialize($exception, 'json'), 400, [], true));
    }
}