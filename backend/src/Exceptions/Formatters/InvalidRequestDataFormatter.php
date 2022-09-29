<?php

declare(strict_types=1);

namespace App\Exceptions\Formatters;

use App\Exceptions\Handlers\InvalidRequestDataHandler;
use App\Infrastructure\Exceptions\InvalidRequestData;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class InvalidRequestDataFormatter
 * @package App\Exceptions\Formatters
 */
class InvalidRequestDataFormatter implements EventSubscriberInterface
{
    /**
     * @var InvalidRequestDataHandler
     */
    private InvalidRequestDataHandler $handler;

    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * InvalidRequestDataFormatter constructor.
     * @param InvalidRequestDataHandler $handler
     * @param SerializerInterface $serializer
     */
    public function __construct(InvalidRequestDataHandler $handler, SerializerInterface $serializer)
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

        if (!$exception instanceof InvalidRequestData) {
            return;
        }

        $this->handler->handle($exception);

        $event->setResponse(new JsonResponse($this->serializer->serialize($exception->getValidates(), 'json'), 400, [], true));
    }
}