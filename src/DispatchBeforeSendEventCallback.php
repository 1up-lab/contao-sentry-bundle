<?php

namespace Oneup\ContaoSentryBundle;

use Oneup\ContaoSentryBundle\Event\BeforeSendEvent;
use Sentry\Event;
use Sentry\EventHint;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class DispatchBeforeSendEventCallback
{
    public function __construct(private EventDispatcherInterface $eventDispatcher)
    {

    }

    public function __invoke(Event $event, ?EventHint $hint): ?Event
    {
        $event = new BeforeSendEvent($event, $hint);
        $this->eventDispatcher->dispatch($event);

        return $event->getEvent();
    }
}