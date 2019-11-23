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
            $options = $client->getOptions();

            return sprintf('https://%s@sentry.io/%s', $options->getPublicKey(), $options->getProjectId());
        }

        return null;
    }
}
