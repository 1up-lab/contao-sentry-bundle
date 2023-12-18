<?php

declare(strict_types=1);

namespace Oneup\Contao\SentryBundle\Twig;

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
            && (null !== $dsn = $client->getOptions()->getDsn())) {

            return sprintf(
                '%s://%s@%s/%s',
                $dsn->getScheme(),
                $dsn->getPublicKey(),
                $dsn->getHost(),
                $dsn->getProjectId()
            );
        }

        return null;
    }
}
