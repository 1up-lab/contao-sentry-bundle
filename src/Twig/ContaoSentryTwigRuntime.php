<?php

declare(strict_types=1);

namespace Oneup\ContaoSentryBundle\Twig;

use Sentry\SentrySdk;

class ContaoSentryTwigRuntime
{
    public function sentryLastEventIdFilter(): ?string
    {
        $lastEventId = SentrySdk::getCurrentHub()->getLastEventId();

        if ($lastEventId === null) {
            return null;
        }

        return (string) $lastEventId;
    }

    public function sentryDsn(): ?string
    {
        if ((null !== $client = SentrySdk::getCurrentHub()->getClient())
            && (null !== $dsn = $client->getOptions()->getDsn())
        ) {
            return (string) $dsn;
        }

        return null;
    }
}
