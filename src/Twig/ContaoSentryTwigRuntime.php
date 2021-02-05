<?php

declare(strict_types=1);

namespace Oneup\Contao\SentryBundle\Twig;

use Sentry\SentryBundle\SentryBundle;

class ContaoSentryTwigRuntime
{
    public function sentryLastEventIdFilter(): ?string
    {
        return SentryBundle::getCurrentHub()->getLastEventId();
    }

    public function sentryDsn(): ?string
    {
        if (null !== $client = SentryBundle::getCurrentHub()->getClient()) {
            $dsn = $client->getOptions()->getDsn(false);

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
