<?php

declare(strict_types=1);

namespace App\Application\EventListener;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class LocaleSubscriber
 *
 * @package App\Application\EventListener
 */
class LocaleSubscriber implements EventSubscriberInterface
{
    /**
     * @var ParameterBagInterface
     */
    private ParameterBagInterface $params;

    /**
     * LocaleSubscriber constructor.
     *
     * @param ParameterBagInterface $params
     */
    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    /**
     * @param RequestEvent $event
     */
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if ($request->headers->has('Locale')) {
            if ($this->params->has('app_locales')) {
                $locales = explode('|', $this->params->get('app_locales'));

                $locale = $request->headers->get('Locale');

                if (in_array($locale, $locales, true)) {
                    if ($request->getLocale() !== $locale) {
                        $request->setLocale($locale);
                    }
                }
            }
        }
    }

    /**
     * @return array[][]
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [['onKernelRequest', 20]],
        ];
    }
}