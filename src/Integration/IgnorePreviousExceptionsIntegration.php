<?php

declare(strict_types=1);

namespace Oneup\ContaoSentryBundle\Integration;

use Sentry\Event;
use Sentry\EventHint;
use Sentry\SentrySdk;

class IgnorePreviousExceptionsIntegration
{
    public function __invoke(Event $event, ?EventHint $hint): ?Event
    {
        if (!($exception = $hint?->exception) instanceof \Throwable) {
            return $event;
        }

        $sentry = SentrySdk::getCurrentHub();

        foreach ($sentry->getClient()?->getOptions()->getIgnoreExceptions() ?? [] as $class) {
            while ($exception && $exception = $exception->getPrevious()) {
                if (\is_a($exception, $class)) {
                    return null;
                }
            }
        }

        return $event;
    }
}
