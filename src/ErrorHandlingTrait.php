<?php

declare(strict_types=1);

namespace Oneup\ContaoSentryBundle;

use Sentry\CheckIn;
use Sentry\CheckInStatus;
use Sentry\Event;
use Sentry\EventHint;
use Sentry\SentrySdk;

trait ErrorHandlingTrait
{
    private string|null $sentryCheckInId = null;

    private function sentryOrThrow(string $message, \Throwable $exception = null, array $contexts = []): void
    {
        $event = Event::createEvent();
        $event->setMessage($message);

        foreach ($contexts as $name => $data) {
            $event->setContext($name, $data);
        }

        if (null === SentrySdk::getCurrentHub()->captureEvent($event, EventHint::fromArray(['exception' => $exception]))) {
            throw new \RuntimeException($message, 0, $exception);
        }
    }

    private function sentryCheckIn(bool $success = null): void
    {
        $checkIn = new CheckIn(
            monitorSlug: substr(__CLASS__, strrpos(__CLASS__, '\\') + 1),
            status: match($success) {
                null => CheckInStatus::inProgress(),
                true => CheckInStatus::ok(),
                false => CheckInStatus::error(),
            },
            id: $this->sentryCheckInId,
        );

        if (null === $this->sentryCheckInId) {
            $this->sentryCheckInId = $checkIn->getId();
        }

        $event = Event::createCheckIn();
        $event->setCheckIn($checkIn);

        SentrySdk::getCurrentHub()->captureEvent($event);
    }
}
