<?php

namespace Oneup\ContaoSentryBundle\Event;

use Sentry\Event;
use Sentry\EventHint;
use Symfony\Contracts\EventDispatcher\Event as SymfonyEvent;

final class BeforeSendEvent extends SymfonyEvent
{
    private Event|null $event;

    public function __construct(Event $event, private EventHint|null $eventHint = null)
    {
        $this->event = $event;
    }

    public function setEvent(Event|null $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function getEventHint(): EventHint|null
    {
        return $this->eventHint;
    }
}