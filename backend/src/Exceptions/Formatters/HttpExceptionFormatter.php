<?php

declare(strict_types=1);

namespace App\Exceptions\Formatters;

use App\Application\Infrastructure\ApiResponse;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class MethodNotAllowedHttpExceptionFormatter
 * @package App\Exceptions\Formatters
 */
class HttpExceptionFormatter implements EventSubscriberInterface
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * HttpExceptionFormatter constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
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


        if(strpos($request->getUri(), '/api-admin/')){
            $errrorCode = $exception->getCode()?: Response::HTTP_INTERNAL_SERVER_ERROR;

            $event->setResponse(new ApiResponse(
                [
                    'message' => $exception->getMessage(),
                    'code' => $errrorCode
                ],
                false,
                $errrorCode
            ));
            return;
        }

        if (strpos($request->getUri(), '/api/') === false) {
            return;
        }

        if (!$exception instanceof HttpException) {
            return;
        }

        $event->setResponse(new JsonResponse($this->serializer->serialize($exception, 'json'), 400, [], true));
    }
}